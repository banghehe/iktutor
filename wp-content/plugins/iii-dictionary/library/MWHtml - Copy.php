<?php

class MWHtml {

	/*
	 * generate Language Selectbox
	 *
	 * @param int   $selected		Selected value
	 * @param array $options		select box options. Available options:
	 *								- $options['first_option']		 first option text. The first option has empty value
	 *								- $options['id']  				 id of the select box
	 *								- $options['name']  			 name of the select box
	 *								- $options['class']  			 additional classes of the select box
	 */
	public static function select_languages($selected = '', $options = array())
	{
		$options['id'] = $options['id'] != '' ? $options['id'] : 'sel-lang';
		$options['name'] = $options['name'] != '' ? $options['name'] : 'sel-lang';
		$options['class'] = $options['class'] != '' ? ' ' . $options['class'] : '';

		$select_options = array(
			'en' => __('English', 'iii-dictionary'),
			'ja' => __('Japanese', 'iii-dictionary'),
			'ko' => __('Korean', 'iii-dictionary'),
			//'vi' => __('Vietnamese', 'iii-dictionary'),
			'zh' => __('Chinese', 'iii-dictionary')
		);
?>
		<select class="select-box-it<?php echo $options['class'] ?>" name="<?php echo $options['name'] ?>" id="<?php echo $options['id'] ?>">
			<?php if($options['first_option'] != '') : ?>
				<option value=""><?php echo $options['first_option'] ?></option>
			<?php endif ?>

			<?php foreach ($select_options as $value => $text) : ?>
				<option value="<?php echo $value ?>"<?php echo $value == $selected ? ' selected' : '' ?>><?php echo  $text ?></option>
			<?php endforeach ?>
		</select>
<?php
	}

	/*
	 * generate Grade Selectbox
	 *
	 * @param string $type			Grade type. Accept: ENGLISH, MATH
	 * @param int $selected		Selected value
	 * @param array $options
	 */
	public static function select_grades($type = 'ENGLISH', $selected = '', $options = array())
	{
		global $wpdb;

		$options['id'] = $options['id'] != '' ? ' id="' . $options['id'] . '"' : '';
		$options['name'] = $options['name'] != '' ? ' name="' . $options['name'] . '"' : '';
		$options['class'] = $options['class'] != '' ? ' ' . $options['class'] : '';
		$options['first_option'] = empty($options['first_option']) ? __('-Grade-', 'iii-dictionary') : $options['first_option'];
		$options['level'] = empty($options['level']) ? 2 : $options['level'];

		$admin_only = is_mw_admin() || is_mw_super_admin() ? 1 : 0;

		$query = 'SELECT id, name 
				FROM ' . $wpdb->prefix . 'dict_grades
				WHERE type = \'' . $type . '\' AND level = ' . $options['level'];

		if(!$admin_only) {	
			if(!is_sat_special_group()) { $query .= ' AND admin_only = 0'; }	
			/*
			if(is_member_SAT()) {
				$query .= ' AND id NOT IN (SELECT id FROM ' . $wpdb->prefix . 'dict_grades WHERE id != '. SAT_GRADE .' AND admin_only = 1)';
			}else {
				$query .= ' AND admin_only = 0';
			}
			*/
		}
		
		$grades = $wpdb->get_results($query);
?>
		<select class="select-box-it<?php echo $options['class'] ?>" <?php echo $options['name']; echo $options['id'] ?>>
			<option value=""><?php echo $options['first_option'] ?></option>
			<?php foreach($grades as $grade) : ?>
				<option value="<?php echo $grade->id ?>"<?php echo $grade->id == $selected ? ' selected' : '' ?>><?php echo $grade->name ?></option>
			<?php endforeach ?>
		</select>
<?php
	}

	/*
	 * generate Homeworks Assignments Select box
	 * English asignment only
	 */
	public static function sel_assignments($selected = '', $get_form = false, $questions = array(), $first_option = '', $name = 'assignments', $class = '', $id = 'assignments', $vocab_option = true)
	{
		global $wpdb;
		$layout = isset($_GET['layout']) ? $_GET['layout'] : '';
		$types = $wpdb->get_results(
			'SELECT a.id, has.name
			 FROM ' . $wpdb->prefix . 'dict_homework_assignments AS a
			 JOIN ' . $wpdb->prefix . 'dict_homework_assignment_langs AS has ON has.assignment_id = a.id
			 WHERE type = \'ENGLISH\'   AND lang = \'' . get_short_lang_code() . '\''
		);

		$class = $class == '' ? '' : ' ' . $class;
		$html = $js = '';

?>
		<select class="select-box-it<?php echo $class ?>" name="<?php echo $name ?>" id="<?php echo $id ?>">
			<?php if($first_option != '') : ?>
				<option value=""><?php echo $first_option ?></option>
			<?php endif ?>
			<?php foreach($types as $type) :
				if($type->id != ASSIGNMENT_VOCAB_BUILDER && $type->id != ASSIGNMENT_REPORT) : ?>
					<option value="<?php echo $type->id ?>"<?php echo $selected == $type->id ? ' selected' : '' ?>><?php echo $type->name ?></option>
				<?php else :
					if(!is_admin_panel() && $vocab_option || ($layout != 'create' && is_admin_panel())) : ?>
						<option value="<?php echo $type->id ?>"<?php echo $selected == $type->id ? ' selected' : '' ?>><?php echo $type->name ?></option>
					<?php endif;
				endif ?>
			<?php endforeach ?>
		</select>

		<?php /* pre-prepared html for sheet input form. TODO: return 1 type if $cid provied */

		if($get_form)
		{
			switch($selected)
			{
				case ASSIGNMENT_SPELLING:
					for($i = 1; $i <= 20; $i++) {
						$html .= '<tr>';
						$html .= 	'<td class="order-number"><span>' . $i . '.</span></td>';
						$html .= 	'<td><input type="text" name="words[]" class="input-box-style2" autocomplete="off" value="' . $questions[$i - 1] . '"></td>';
						$html .= '</tr>';
					}
					break;
				case ASSIGNMENT_VOCAB_GRAMMAR:
					for($i = 1; $i <= 20; $i++) {
						$html .= '<tr data-index="' . $i . '">';
						$html .= 	'<td class="order-number"><span>' .$i . '.</span></td>';
						$html .= 	'<td><a class="btn btn-tiny orange" href="#" onClick="return false">Subject</a><input type="text" name="words[quiz][]" class="quiz_input" value="' . $questions['quiz'][$i - 1] . '"></td>';
						$html .= 	'<td><a class="btn btn-tiny orange" href="#" onClick="return false">Question</a><input type="text" name="words[question][]" class="sentence_input" value="' . $questions['question'][$i - 1] . '"></td>';
						$html .= 	'<td><input type="text" name="words[c_answer][]" class="input-box-style2" autocomplete="off" value="' . $questions['c_answer'][$i - 1] . '"></td>';
						$html .= 	'<td><input type="text" name="words[w_answer1][]" class="input-box-style2" autocomplete="off" value="' . $questions['w_answer1'][$i - 1] . '"></td>';
						$html .= 	'<td><input type="text" name="words[w_answer2][]" class="input-box-style2" autocomplete="off" value="' . $questions['w_answer2'][$i - 1] . '"></td>';
						$html .= 	'<td><input type="text" name="words[w_answer3][]" class="input-box-style2" autocomplete="off" value="' . $questions['w_answer3'][$i - 1] . '"></td>';
						$html .= 	'<td><input type="text" name="words[w_answer4][]" class="input-box-style2" autocomplete="off" value="' . $questions['w_answer4'][$i - 1] . '"></td>';
						$html .= '</tr>';
					}
					break;
				case ASSIGNMENT_READING:
					for($i = 1; $i <= 20; $i++) {
						$html .= '<tr data-index="' . $i . '">';
						$html .= 	'<td class="order-number"><span>' .$i . '.</span></td>';
						$html .= 	'<td><input type="text" name="words[quiz][]" class="input-box-style2" value="' . esc_html($questions['quiz'][$i - 1]) . '"></td>';
						$html .= 	'<td class="hidden"><a class="btn btn-tiny orange" href="#" onClick="return false">Question</a><input type="text" name="words[question][]" class="sentence_input" value="' . esc_html($questions['question'][$i - 1]) . '"></td>';
						$html .= 	'<td class="hidden"><a class="btn btn-tiny orange" href="#" onClick="return false">Correct</a><input type="text" name="words[c_answer][]" class="sentence_input" value="' . esc_html($questions['c_answer'][$i - 1]) . '"></td>';
						$html .= 	'<td class="hidden"><a class="btn btn-tiny orange" href="#" onClick="return false">Incorrect 1</a><input type="text" name="words[w_answer1][]" class="sentence_input" value="' . esc_html($questions['w_answer1'][$i - 1]) . '"></td>';
						$html .= 	'<td class="hidden"><a class="btn btn-tiny orange" href="#" onClick="return false">Incorrect 2</a><input type="text" name="words[w_answer2][]" class="sentence_input" value="' . esc_html($questions['w_answer2'][$i - 1]) . '"></td>';
						$html .= 	'<td class="hidden"><a class="btn btn-tiny orange" href="#" onClick="return false">Incorrect 3</a><input type="text" name="words[w_answer3][]" class="sentence_input" value="' . esc_html($questions['w_answer3'][$i - 1]) . '"></td>';
						$html .= 	'<td class="hidden"><a class="btn btn-tiny orange" href="#" onClick="return false">Incorrect 4</a><input type="text" name="words[w_answer4][]" class="sentence_input" value="' . esc_html($questions['w_answer4'][$i - 1]) . '"></td>';
						$html .= '</tr>';
					}
					break;
				case ASSIGNMENT_WRITING:
					for($i = 1; $i <= 20; $i++) {
						$html .= '<tr data-index="' . $i . '">';
						$html .= 	'<td class="order-number"><span>' .$i . '.</span></td>';
						$html .= 	'<td><input type="text" name="words[quiz][]" class="input-box-style2" value="' . $questions['quiz'][$i - 1] . '"></td>';
						$html .= 	'<td class="hidden"><textarea name="words[question][]" class="sentence_input">' . $questions['question'][$i - 1] . '</textarea></td>';						
						$html .= '</tr>';
					}
					break;
				case ASSIGNMENT_VOCAB_BUILDER:
					if(!is_admin_panel()) {
						for($i = 1; $i <= 20; $i++) {
							$html .= '<tr>';
							$html .= 	'<td class="order-number"><span>' . $i . '.</span></td>';
							$html .= 	'<td class="fc"><input type="text" name="words[word][]" class="input-box-style2" autocomplete="off" value="' . $questions['word'][$i - 1] . '" placeholder="Word"></td>';
							$html .= 	'<td><input type="text" name="words[sentence][]" class="input-box-style2" autocomplete="off" value="' . $questions['sentence'][$i - 1] . '" placeholder="Sentence"></td>';
							$html .= '</tr>';
						}
					}
					break;
			}

			$js .= '<script>
					(function($){
						$(function(){';

							if($selected == ASSIGNMENT_READING) {
								$js .=  '$("#reading-passage-block").show();';
							}
							if($selected != ASSIGNMENT_SPELLING) {
								$js .=  '$("#check-word").hide();';
							}
							if($selected == ASSIGNMENT_REPORT) {
								$js .=  'var _h = $("#sheet-header-block"); _h.removeClass("col-md-5");
										$("#import-block").hide(); $("#questions-sheet").hide();$("#report-assignment-block").show();';
							}
							if($selected == ASSIGNMENT_VOCAB_BUILDER) {
								$js .=  '$("#description-block").hide();';
							}

							// ugly hack
							if(!isset($_POST['words']) && !isset($_GET['cid'])) {
								$js .= 'setup_sheet_layout($("#' . $id . '").val());';
							}

			$js .=  		'$("#' . $id . '").change(function(){
								setup_sheet_layout($(this).val());
							});
						});
					})(jQuery);
				</script>';

			return array('html' => $html, 'js' => $js);
		}
	}

	/*
	 * generate Homeworks Types Select box
	 *
	 * @param int   $selected	selected value
	 * @param array $options	select box options. Available options:
	 *							- $options['first_option']		 first option text. The first option has empty value
	 *							- $options['admin_panel']  		 select box is displayed in admin panel
	 *							- $options['subscribed_option']  display "Subscribed" option
	 *							- $options['id']  				 id of the select box
	 *							- $options['name']  			 name of the select box
	 *							- $options['class']  			 additional classes of the select box
	 */
	public static function sel_homework_types($selected = '', $options = array())
	{
		// set default value
		if(!isset($options['admin_panel'])) $options['admin_panel'] = false;
		if(!isset($options['subscribed_option'])) $options['subscribed_option'] = false;
		$options['id'] = $options['id'] != '' ? $options['id'] : 'homework-types';
		$options['name'] = $options['name'] != '' ? $options['name'] : 'homework-types';
		$options['class'] = $options['class'] != '' ? ' ' . $options['class'] : '';

		// "Public" option is always on
		$select_options = array(HOMEWORK_PUBLIC => __('Public', 'iii-dictionary'));

		if(!$options['admin_panel']) {
			$select_options[HOMEWORK_MY_OWN]   = __('My Own', 'iii-dictionary');
			$select_options[HOMEWORK_LICENSED] = __('Licensed', 'iii-dictionary');
		}

		if($options['subscribed_option']) {
			$select_options[HOMEWORK_SUBSCRIBED] = __('Subscribed', 'iii-dictionary');
		}

		// if current user is admin, print "Class" option
		if(is_mw_admin() || is_mw_super_admin()) {
			$select_options[HOMEWORK_CLASS] = __('Class', 'iii-dictionary');
		}
	?>
		<select class="select-box-it<?php echo $options['class'] ?>" name="<?php echo $options['name'] ?>" id="<?php echo $options['id'] ?>">
			<?php if($options['first_option'] != '') : ?>
				<option value=""><?php echo $options['first_option'] ?></option>
			<?php endif ?>

			<?php foreach ($select_options as $value => $text) : ?>
				<option value="<?php echo $value ?>"<?php echo $value == $selected ? ' selected' : '' ?>><?php echo  $text ?></option>
			<?php endforeach ?>
		</select>
	<?php
	}

	/*
	 * generate Homeworks Types Select box
	 */
	public static function sel_sheet_categories($selected = '', $admin = true, $name = 'sheet-categories', $class = '', $id = 'sheet-categories')
	{
		global $wpdb;

		$categories = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'dict_sheet_categories');

		$class = $class == '' ? '' : ' ' . $class;
	?>
		<select class="select-box-it<?php echo $class ?>" name="<?php echo $name ?>" id="<?php echo $id ?>">
			<?php foreach($categories as $category) : ?>
				<?php if($category->id != 5) : ?>
					<option value="<?php echo $category->id ?>"<?php echo $selected == $category->id ? ' selected' : '' ?>><?php echo $category->name ?></option>
				<?php else : ?>
					<?php if($admin) : ?>
						<option value="<?php echo $category->id ?>"<?php echo $selected == $category->id ? ' selected' : '' ?>><?php echo $category->name ?></option>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
		</select>
	<?php
	}

	/*
	 * generate Math assignments selectbox
	 *
	 * @param mixed $selected		Selected value
	 * @param array $options
	 */
	public static function sel_math_assignments($selected = 1, $options = array('name' => 'math-assignments', 'id' => 'math-assignments'))
	{
		global $wpdb;

		if(!empty($options['first-option'])) {
			$options['first-option'] = '<option value="">' . $options['first-option'] . '</option>';
		}

		if(!empty($options['class'])) {
			$options['class'] = ' ' . $options['class'];
		}

		$assignments = $wpdb->get_results(
			'SELECT a.id, has.name
			 FROM ' . $wpdb->prefix . 'dict_homework_assignments AS a
			 JOIN ' . $wpdb->prefix . 'dict_homework_assignment_langs AS has ON has.assignment_id = a.id
			 WHERE type = \'MATH\' AND lang = \'' . get_short_lang_code() . '\''
		);
?>
		<select class="select-box-it form-control<?php echo $options['class'] ?>" id="<?php echo $options['id'] ?>" name="<?php echo $options['name'] ?>">
			<?php echo $options['first-option'] ?>
			<?php foreach($assignments as $item) : ?>
				<option value="<?php echo $item->id ?>"<?php echo $selected == $item->id ? ' selected' : '' ?>><?php echo $item->name ?></option>
			<?php endforeach ?>
		</select>
<?php
	}

	/*
	 * generate create question form for math sheet
	 *
	 * @param string $sel_assignments_id		id of select tag
	 * @param array $data			inputed data
	 */
	public static function math_worksheet_form($data = array(), $sel_assignments_id = 'math-assignments')
	{
		$signs = array('+' => 'Addition', '-' => 'Subtraction', 'x' => 'Multiplication');
		$flashcard_ops = array('' => '(none)', '+' => '+', '-' => '-', 'x' => 'x', '247' => '&divide;');
?>
		<div id="math-sheet-form-<?php echo MATH_ASSIGNMENT_SINGLE_DIGIT ?>" class="math-sheet-form">
			<div class="form-group">
				<input type="text" class="form-control" name="questions[question]" placeholder="<?php _e('Question', 'iii-dictionary') ?>" value="<?php echo $data['question'] ?>">
			</div>
			<table class="table table-striped table-condensed ik-table1 vertical-middle text-center">
				<thead>
					<tr><th><?php _e('Comment', 'iii-dictionary') ?></th><th><?php _e('Sign', 'iii-dictionary') ?></th><th><?php _e('Number', 'iii-dictionary') ?></th></tr>
				</thead>
				<tbody>
					<tr>
						<td><?php _e('Number 1', 'iii-dictionary') ?></td>
						<td>
							<select class="select-box-it" name="questions[sign]" id="sign-sel-single">
								<?php foreach($signs as $sign => $name) : ?>
									<option value="<?php echo $sign ?>"<?php echo $sign == $data['sign'] ? ' selected' : '' ?>><?php echo $name ?></option>
								<?php endforeach ?>
							</select>
						</td>
						<td><input type="text" name="questions[op1]" class="input-box-style2 num-box" value="<?php echo $data['op1'] ?>"></td>
					</tr>
					<tr>
						<td><?php _e('Number 2', 'iii-dictionary') ?></td><td></td>
						<td><input type="text" name="questions[op2]" class="input-box-style2 num-box" value="<?php echo $data['op2'] ?>"></td>
					</tr>
					<tr>
						<td><?php _e('Partial Sum', 'iii-dictionary') ?></td><td></td>
						<td><input type="text" name="questions[step][s1]" class="input-box-style2 num-box" value="<?php echo $data['step']['s1'] ?>"></td>
					</tr>
					<tr>
						<td id="_carry_lbl"><?php _e('Carry', 'iii-dictionary') ?></td><td></td>
						<td><input type="text" name="questions[step][s2]" class="input-box-style2 num-box" value="<?php echo $data['step']['s2'] ?>"></td>
					</tr>
					<tr>
						<td><?php _e('Answer', 'iii-dictionary') ?></td><td></td>
						<td><input type="text" name="questions[step][s3]" class="input-box-style2 num-box" value="<?php echo $data['step']['s3'] ?>"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="math-sheet-form-<?php echo MATH_ASSIGNMENT_TWO_DIGIT_MUL ?>" class="math-sheet-form">
			<div class="form-group">
				<input type="text" class="form-control" name="questions[question]" placeholder="<?php _e('Question', 'iii-dictionary') ?>" value="<?php echo $data['question'] ?>">
			</div>
			<table class="table table-striped table-condensed ik-table1 vertical-middle text-center">
				<thead>
					<tr><th><?php _e('Comment', 'iii-dictionary') ?></th><th><?php _e('Number', 'iii-dictionary') ?></th><th><?php _e('Note', 'iii-dictionary') ?></th></tr>
				</thead>
				<tbody>
					<tr>
						<td><?php _e('Multiplicand', 'iii-dictionary') ?></td>
						<td><input type="text" name="questions[op1]" class="input-box-style2 num-box" value="<?php echo $data['op1'] ?>">
							<input type="hidden" name="questions[sign]" value="x"></td>
						<td></td>
					</tr>
					<tr>
						<td><?php _e('Multiplier', 'iii-dictionary') ?></td>
						<td><input type="text" name="questions[op2]" class="input-box-style2 num-box" value="<?php echo $data['op2'] ?>"></td><td></td>
					</tr>
					<tr>
						<td><?php _e('Partial Sum', 'iii-dictionary') ?></td>
						<td><input type="text" name="questions[step][s1]" class="input-box-style2 num-box" value="<?php echo $data['step']['s1'] ?>"></td><td></td>
					</tr>
					<tr>
						<td><?php _e('Carry', 'iii-dictionary') ?></td>
						<td><input type="text" name="questions[step][s2]" class="input-box-style2 num-box" value="<?php echo $data['step']['s2'] ?>"></td><td></td>
					</tr>
					<tr>
						<td><?php _e('Partial Sum', 'iii-dictionary') ?></td>
						<td><input type="text" name="questions[step][s3]" class="input-box-style2 num-box" value="<?php echo $data['step']['s3'] ?>"></td><td></td>
					</tr>
					<tr>
						<td><?php _e('Carry', 'iii-dictionary') ?></td>
						<td><input type="text" name="questions[step][s4]" class="input-box-style2 num-box" value="<?php echo $data['step']['s4'] ?>"></td><td></td>
					</tr>
					<tr>
						<td><?php _e('Partial Sum', 'iii-dictionary') ?></td>
						<td><input type="text" name="questions[step][s5]" class="input-box-style2 num-box" value="<?php echo $data['step']['s5'] ?>"></td><td></td>
					</tr>
					<tr>
						<td><?php _e('Carry', 'iii-dictionary') ?></td>
						<td><input type="text" name="questions[step][s6]" class="input-box-style2 num-box" value="<?php echo $data['step']['s6'] ?>"></td><td></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="text" name="questions[step][s7]" class="input-box-style2 num-box" value="<?php echo $data['step']['s7'] ?>"></td>
						<td><?php _e('Answer', 'iii-dictionary') ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="math-sheet-form-<?php echo MATH_ASSIGNMENT_SINGLE_DIGIT_DIV ?>" class="math-sheet-form">
			<div class="form-group">
				<input type="text" class="form-control" name="questions[question]" placeholder="<?php _e('Question', 'iii-dictionary') ?>" value="<?php echo $data['question'] ?>">
			</div>
			<table class="table table-striped table-condensed ik-table1 vertical-middle text-center">
				<thead>
					<tr><th><?php _e('Comment', 'iii-dictionary') ?></th><th><?php _e('Number', 'iii-dictionary') ?></th></tr>
				</thead>
				<tbody>
					<tr>
						<td><?php _e('Answer', 'iii-dictionary') ?></td>
						<td><input type="text" name="questions[answer]" class="input-box-style2" value="<?php echo $data['answer'] ?>"></td>
					</tr>
					<tr>
						<td><?php _e('Dividend', 'iii-dictionary') ?></td>
						<td><input type="text" name="questions[op1]" class="input-box-style2" value="<?php echo $data['op1'] ?>"></td>
					</tr>
					<tr>
						<td><?php _e('Divisor', 'iii-dictionary') ?></td>
						<td><input type="text" name="questions[op2]" class="input-box-style2" value="<?php echo $data['op2'] ?>"></td>
					</tr>
					<tr>
						<td><?php _e('Steps', 'iii-dictionary') ?></td>
						<td><textarea name="questions[steps]" class="textarea-style2" rows="5"><?php echo $data['steps'] ?></textarea></td>
					</tr>
					<tr>
						<td><?php _e('Remainder', 'iii-dictionary') ?></td>
						<td><input type="text" name="questions[remainder]" class="input-box-style2" value="<?php echo $data['remainder'] ?>"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="math-sheet-form-<?php echo MATH_ASSIGNMENT_FLASHCARD ?>" class="math-sheet-form">
			<div class="form-group">
				<input type="text" class="form-control" name="questions[question]" placeholder="<?php _e('Question', 'iii-dictionary') ?>" value="<?php echo $data['question'] ?>">
			</div>
			<table class="table table-striped table-condensed ik-table1 vertical-middle text-center">
				<thead>
					<tr><th></th><th><?php _e('Op1', 'iii-dictionary') ?></th><th><?php _e('Op', 'iii-dictionary') ?></th><th><?php _e('Op2', 'iii-dictionary') ?></th><th><?php _e('Equal', 'iii-dictionary') ?></th><th><?php _e('Answer', 'iii-dictionary') ?></th><th><?php _e('Note', 'iii-dictionary') ?></th></tr>
				</thead>
				<tbody>
					<?php for($i = 1; $i <= 20; $i++) : ?>
						<tr>
							<td class="order-number"><?php echo $i ?>.</td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][op1]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['op1'] ?>"></td>
							<td style="width: 99px">
								<select class="select-box-it" name="questions[q][q<?php echo $i ?>][op]">
									<?php foreach($flashcard_ops as $v => $op) : ?>
										<option value="<?php echo $v ?>"<?php echo $v == $data['q']['q' . $i]['op'] ? ' selected' : '' ?>><?php echo $op ?></option>
									<?php endforeach ?>
								</select>
							</td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][op2]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['op2'] ?>"></td>
							<td>=</td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][answer]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['answer'] ?>"></td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][note]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['note'] ?>"></td>
						</tr>
					<?php endfor ?>
				</tbody>
			</table>
		</div>
		<div id="math-sheet-form-<?php echo MATH_ASSIGNMENT_FRACTION ?>" class="math-sheet-form">
			<div class="form-group">
				<input type="text" class="form-control" name="questions[question]" placeholder="<?php _e('Question', 'iii-dictionary') ?>" value="<?php echo $data['question'] ?>">
			</div>
			<table class="table table-striped table-condensed ik-table1 vertical-middle text-center">
				<thead>
					<tr><th></th><th><?php _e('Op1', 'iii-dictionary') ?></th><th><?php _e('Op', 'iii-dictionary') ?></th><th><?php _e('Op2', 'iii-dictionary') ?></th><th><?php _e('Equal', 'iii-dictionary') ?></th><th><?php _e('Answer', 'iii-dictionary') ?></th></tr>
				</thead>
				<tbody>
					<?php for($i = 1; $i <= 20; $i++) : ?>
						<tr>
							<td class="order-number"><?php echo $i ?>.</td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][op1]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['op1'] ?>"></td>
							<td style="width: 99px">
								<select class="select-box-it" name="questions[q][q<?php echo $i ?>][op]">
									<?php foreach($flashcard_ops as $v => $op) : ?>
										<option value="<?php echo $v ?>"<?php echo $v == $data['q']['q' . $i]['op'] ? ' selected' : '' ?>><?php echo $op ?></option>
									<?php endforeach ?>
								</select>
							</td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][op2]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['op2'] ?>"></td>
							<td>=</td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][answer]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['answer'] ?>"></td>
						</tr>
					<?php endfor ?>
				</tbody>
			</table>
		</div>
		<div id="math-sheet-form-<?php echo MATH_ASSIGNMENT_WORD_PROB ?>" class="math-sheet-form">
			<div class="form-group">
				<input type="text" class="form-control" name="questions[question]" placeholder="<?php _e('Question', 'iii-dictionary') ?>" value="<?php echo $data['question'] ?>">
			</div>
			<table class="table table-striped table-condensed ik-table1 vertical-middle text-center">
				<thead>
					<tr><th></th><th>PNG</th><th>MP3</th><th style="width: 100px"><?php _e('Control Parameter', 'iii-dictionary') ?></th></tr>
				</thead>
				<tbody>
					<tr>
						<td><?php _e('Answer', 'iii-dictionary') ?></td><td colspan="3"><input type="text" name="questions[answer]" class="input-box-style2" value="<?php echo $data['answer'] ?>"></td>
					</tr>
					<?php for($i = 1; $i <= 20; $i++) : ?>
						<tr>
							<td><?php printf(__('Step %d.', 'iii-dictionary'), $i) ?></td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][image]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['image'] ?>"></td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][sound]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['sound'] ?>"></td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][param]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['param'] ?>"></td>
						</tr>
					<?php endfor ?>
				</tbody>
			</table>
		</div>
		<div id="math-sheet-form-<?php echo MATH_ASSIGNMENT_QUESTION_BOX ?>" class="math-sheet-form">
			<div class="form-group">
				<input type="text" class="form-control" name="questions[question]" placeholder="<?php _e('Question', 'iii-dictionary') ?>" value="<?php echo $data['question'] ?>">
			</div>
			<table class="table table-striped table-condensed ik-table1 vertical-middle text-center">
				<thead>
					<tr><th></th><th><?php _e('X-cord', 'iii-dictionary') ?> <small class="text-muted">(%)</small></th>
					<th><?php _e('Y-cord', 'iii-dictionary') ?> <small class="text-muted">(%)</small></th>
					<th><?php _e('Width', 'iii-dictionary') ?> <small class="text-muted">(%)</small></th>
					<th><?php _e('Height', 'iii-dictionary') ?> <small class="text-muted">(%)</small></th>
					<th></th><th><?php _e('Value', 'iii-dictionary') ?></th><th><?php _e('Image', 'iii-dictionary') ?></th></tr>
				</thead>
				<tbody>
					<?php for($i = 1; $i <= 20; $i++) : ?>
						<tr>
							<td class="order-number"><?php echo $i ?>.</td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][x-cord]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['x-cord'] ?>"></td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][y-cord]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['y-cord'] ?>"></td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][width]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['width'] ?>"></td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][height]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['height'] ?>"></td>
							<td>=</td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][answer]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['answer'] ?>"></td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][image]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['image'] ?>"></td>
						</tr>
					<?php endfor ?>
				</tbody>
			</table>
		</div>
		<div id="math-sheet-form-<?php echo MATH_ASSIGNMENT_EQUATION ?>" class="math-sheet-form">
			<div class="form-group">
				<input type="text" class="form-control" name="questions[question]" placeholder="<?php _e('Question', 'iii-dictionary') ?>" value="<?php echo $data['question'] ?>">
			</div>
			<table class="table table-striped table-condensed ik-table1 vertical-middle text-center">
				<thead>
					<tr><th></th><th><?php _e('Equation', 'iii-dictionary') ?></th><th><?php _e('Answer', 'iii-dictionary') ?></th><th style="width: 100px"><?php _e('Note', 'iii-dictionary') ?></th></tr>
				</thead>
				<tbody>
					<?php for($i = 1; $i <= 20; $i++) : ?>
						<tr>
							<td class="order-number"><?php echo $i ?>.</td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][equation]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['equation'] ?>"></td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][answer]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['answer'] ?>"></td>
							<td><input type="text" name="questions[q][q<?php echo $i ?>][note]" class="input-box-style2" value="<?php echo $data['q']['q' . $i]['note'] ?>"></td>
						</tr>
					<?php endfor ?>
				</tbody>
			</table>
		</div>

<script>
	(function($){
		$(function(){
			var _fid = $("#<?php echo $sel_assignments_id ?>").val();
			_fid = _fid == <?php echo MATH_ASSIGNMENT_TWO_DIGIT_DIV ?> ? <?php echo MATH_ASSIGNMENT_SINGLE_DIGIT_DIV ?> : _fid;
			$(".math-sheet-form").hide().find("input, select, textarea").prop("disabled", true);
			$("#math-sheet-form-" + _fid).show().find("input, select, textarea").prop("disabled", false);
			if(_fid == <?php echo MATH_ASSIGNMENT_FLASHCARD ?>) $("#time-limit-block").removeClass("hidden");
			$("#sign-sel-single").change(function(){
				$(this).val() == "-" ? $("#_carry_lbl").text("<?php _e('Borrow', 'iii-dictionary') ?>") : $("#_carry_lbl").text("<?php _e('Carry', 'iii-dictionary') ?>");
			});
			$("#<?php echo $sel_assignments_id ?>").change(function(){
				var _fid = $(this).val();
				_fid = _fid == <?php echo MATH_ASSIGNMENT_TWO_DIGIT_DIV ?> ? <?php echo MATH_ASSIGNMENT_SINGLE_DIGIT_DIV ?> : _fid;
				$(".math-sheet-form").hide().find("input, select, textarea").prop("disabled", true);
				$("#math-sheet-form-" + _fid).show().find("input, select, textarea").prop("disabled", false);
				_fid == <?php echo MATH_ASSIGNMENT_FLASHCARD ?> ? $("#time-limit-block").removeClass("hidden") : $("#time-limit-block").addClass("hidden");
			});
			$("#sign-sel-single").trigger("change");
		});
	})(jQuery);
</script>
<?php
	}

	/*
	 * generate select level page content
	 *
	 * @param array $levels
	 */
	public static function select_math_level_page($levels)
	{
		$route = get_route();
		$ref = locale_home_url() . '/?r=' . $route[0];
?>
		<div class="row">
			<?php foreach($levels as $level) : 
				$sublevels = MWDB::get_grades(array('type' => 'MATH', 'level' => 2, 'parent_id' => $level->id, 'orderby' => 'ordering', 'order-dir' => 'asc')) ?>
				<section class="col-sm-12 math-levels">
					<h6 class="math-level-title"><?php echo $level->name ?></h6>
					<ul class="math-sublevels">
						<?php foreach($sublevels as $subitem) : ?>
							<li class="select-math-level" data-level="<?php echo $subitem->id ?>"><?php echo $subitem->name ?></li>
						<?php endforeach ?>
					</ul>
				</section>
			<?php endforeach ?>
			<input type="hidden" id="uref" value="<?php echo rawurlencode(base64_encode($ref)) ?>">
		</div>

<div id="select-math-worksheet-dialog" class="modal fade modal-large modal-green" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <a href="#" data-dismiss="modal" aria-hidden="true" class="close"></a>
            <h3><?php _e('Select Worksheet', 'iii-dictionary') ?></h3>
        </div>
        <div class="modal-body">
			<div class="row">
				<div class="col-sm-3 form-group">
					<label><?php _e('Math level:', 'iii-dictionary') ?></label>
					<h5 id="math-category"></h5>
					<h4 id="math-level"></h4>
					<h5 id="math-sublevel"></h5>
				</div>
				<div class="col-sm-9 form-group">
					<div class="scroll-list2" style="max-height: 500px">
						<table class="table ik-table2 ik-table-green" id="sel-worksheets" data-empty-msg="<?php _e('No worksheets', 'iii-dictionary') ?>"></table>
					</div>
				</div>
			</div>
        </div>
      </div>
    </div>
</div>

<?php
	}

	/*
	 * generate a digit box for math homework
	 *
	 * @param string $digits
	 * @param string $sign
	 * @param int $empty_box
	 */
	public static function math_digit_box($digits, $sign = null, $empty_box = 0)
	{
		$digits = str_split($digits);
?>
		<span class="formula-steps">
			<?php if(!empty($sign)) : ?>
				<span class="math-number sign"><?php echo $sign ?></span>
				<?php if($empty_box > 0) :
						for($i = 1; $i <= $empty_box; $i++) : ?>
							<span class="math-number empty">&nbsp;</span>
					<?php endfor;
					endif ?>
			<?php endif ?>
			<?php foreach($digits as $d) : ?>
				<span class="math-number"><?php echo $d ?></span>
			<?php endforeach ?>
		</span>
<?php
	}

	/*
	 * generate a digit box for division math homework
	 *
	 * @param string $dividend
	 * @param string $divisor
	 */
	public static function math_digit_box_division($dividend, $divisor)
	{
		$dividend = str_split($dividend);
		$divisor = str_split($divisor);
?>
		<span class="formula-steps">
			<?php foreach($divisor as $d) : ?>
				<span class="math-number"><?php echo $d ?></span>
			<?php endforeach ?>
			<span class="math-number empty division-line">&nbsp;</span>
			<?php foreach($dividend as $d) : ?>
				<span class="math-number dividend"><?php echo $d ?></span>
			<?php endforeach ?>
		</span>
<?php
	}

	/*
	 * gererate an answer box for math homework
	 *
	 * @param string $digits
	 * @param int $step_number
	 */
	public static function math_answer_box($digits, $step_number, $input_name_prefix = '')
	{
		$digits = trim($digits);

		if($digits !== '')
		{
			$digits = str_split($digits);
?>
			<span class="formula-steps" id="answer-step-<?php echo $step_number ?>">
				<?php foreach($digits as $d) : ?>
					<?php if($d === '@') : ?>
						<span class="math-number empty">&nbsp;</span>
					<?php else : ?>
						<span class="math-number input-box"><input type="text" class="s1" maxlength="1" autocomplete="off" data-answer="<?php echo $d ?>"<?php echo $input_name_prefix != '' ? ' name="' . $input_name_prefix . '[]"' : '' ?>></span>
					<?php endif ?>
				<?php endforeach ?>
			</span>
<?php
		}
	}

	/*
	 * return math problem image url
	 *
	 * @param string $file_name
	 *
	 * @return string
	 */
	public static function math_image_url($file_name)
	{
		//$server_url = 'http://mwd.s3.amazonaws.com/mathimages/' . get_short_lang_code() . '/';
		$server_url = site_url() . '/media/mathimages/' . get_short_lang_code() . '/' ;
		return $server_url . $file_name;
	}

		/*
	 * return math problem sound url
	 *
	 * @param string $file_name
	 *
	 * @return string
	 */
	public static function math_sound_url($file_name)
	{
		$server_url = 'http://mwd.s3.amazonaws.com/mathsounds/' . get_short_lang_code() . '/';
		
		return $server_url . $file_name;
	}

	/*
	 * return homework practice url
	 */
	public static function get_practice_page_url($assignment_id)
	{
		$baseurl = site_home_url();

		switch($assignment_id)
		{
			case ASSIGNMENT_SPELLING: $page = 'spelling-practice';
				break;
			case ASSIGNMENT_VOCAB_GRAMMAR: $page = 'vocabulary-practice';
				break;
			case ASSIGNMENT_READING: $page = 'reading-comprehension';
				break;
			case ASSIGNMENT_WRITING: $page = 'writing-practice';
				break;
			case ASSIGNMENT_REPORT: $page = 'writing-report';
				break;
			case MATH_ASSIGNMENT_SINGLE_DIGIT:
			case MATH_ASSIGNMENT_TWO_DIGIT_MUL:
			case MATH_ASSIGNMENT_SINGLE_DIGIT_DIV:
			case MATH_ASSIGNMENT_TWO_DIGIT_DIV:
			case MATH_ASSIGNMENT_FLASHCARD:
			case MATH_ASSIGNMENT_FRACTION:
			case MATH_ASSIGNMENT_WORD_PROB:
			case MATH_ASSIGNMENT_QUESTION_BOX:
			case MATH_ASSIGNMENT_EQUATION:
				$baseurl = site_home_url();
				$page = 'math-homework';
				break;
		}
		return $baseurl . '/?r=' . $page;

	}

	/*
	 * Generate dictionaries select box
	 */
	public static function select_dictionaries($selected = '', $subscription = false, $name = 'dictionary', $id = 'sel-dictionary', $class = '', $all = false)
	{
		global $wpdb;

		$class = $class != '' ? ' ' . $class : $class;

		$dictionaries = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'dict_dictionaries');
	?>
		<select name="<?php echo $name ?>" class="select-box-it<?php echo $class ?>" id="<?php echo $id ?>">
			<option value=""><?php _e('Select a dictionary', 'iii-dictionary') ?></option>			
			<?php for($i = 0; $i < 5; $i++) : ?>
				<option value="<?php echo $dictionaries[$i]->id ?>"<?php echo $selected == $dictionaries[$i]->id ? ' selected' : '' ?>><?php echo $dictionaries[$i]->name ?></option>
			<?php endfor ?>
			<?php if($all) : ?>
				<option value="<?php echo $dictionaries[5]->id ?>"<?php echo $dictionaries[5]->id == $selected ? ' selected' : '' ?>><?php echo $dictionaries[5]->name ?></option>
			<?php endif ?>
			<?php if($subscription) : ?>
				<option value="0"<?php echo '0' == $selected ? ' selected' : '' ?>><?php _e('My Choice', 'iii-dictionary') ?></option>
			<?php endif ?>
		</select>
	<?php
	}

	/*
	 * Generate select box number of students for subscription
	 */
	public static function select_num_of_students_subscription($selected = '', $name = 'num-of-students', $id = 'sel-num-students')
	{		
	?>
		<select name="<?php echo $name ?>" id="<?php echo $id ?>" class="select-box-it">
			<option value=""><?php _e('Select one', 'iii-dictionary') ?></option>
			<?php for($i = 1; $i <= 9; $i++) : $n = $i * STUDENT_MULTIPLIER ?>
				<option value="<?php echo $n ?>"<?php echo $selected == $n ? ' selected' : '' ?>><?php printf(__('%s students/licenses', 'iii-dictionary'), $n) ?></option>
			<?php endfor ?>
		</select>
	<?php
	}

	/*
	 * Generate select box number of months for subscription
	 */
	public static function select_num_of_months_dict_subscription($selected = '', $name = 'dict-num-of-months', $id = 'sel-dict-months')
	{ ?>
		<select name="<?php echo $name ?>" id="<?php echo $id ?>" class="select-box-it">
			<option value=""><?php _e('Select one', 'iii-dictionary') ?></option>
			<option value="1"<?php echo '1' == $selected ? ' selected' : '' ?>>1 month</option>
			<option value="3"<?php echo '3' == $selected ? ' selected' : '' ?>>3 month</option>
			<?php for($i = 1; $i <= 4; $i++) : $n = $i * DICTIONARY_MONTHS_MULTIPLIER ?>
				<option value="<?php echo $n ?>"<?php echo $selected == $n ? ' selected' : '' ?>><?php printf(__('%s months', 'iii-dictionary'), $n) ?></option>
			<?php endfor ?>
		</select>
	<?php
	}

	/*
	 * Generate select box number of months for teacher's tool subscription
	 */
	public static function select_num_of_months_teacher_subscription($selected = '', $name = 'teacher-tool-months', $id = 'sel-teacher-tool', $month_only = false)
	{ ?>
		<select class="select-box-it form-control" id="<?php echo $id ?>" name="<?php echo $name ?>">
			<option value=""><?php _e('Select one', 'iii-dictionary') ?></option>
			<option value="1"<?php echo '1' == $selected ? ' selected' : '' ?>>1 month</option>
			<?php for($m = 2; $m <= 8; $m++) : ?>
				<option value="<?php echo $m ?>"<?php echo $m == $selected ? ' selected' : '' ?>><?php printf(__('%s months', 'iii-dictionary'), $m) ?></option>
			<?php endfor ?>
			<option value="12"<?php echo '12' == $selected ? ' selected' : '' ?>>1 year</option>
		</select>
	<?php
	}

	/*
	 * Generate select box credit code type
	 */
	public static function select_credit_code_type($selected = '', $name = 'filter[type]', $id = '')
	{
		global $wpdb;
		
		$types = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'dict_subscription_type');
	?>
		<select name="<?php echo $name ?>" class="select-box-it select-sapphire form-control">
			<option value=""><?php _e('--Type--', 'iii-dictionary') ?></option>
			<?php foreach($types as $type) : ?>
				<?php if($type->id != 4) : ?>
					<option value="<?php echo $type->id ?>"<?php echo $selected == $type->id ? ' selected' : '' ?>><?php echo $type->name ?></option>
				<?php endif ?>
			<?php endforeach ?>
		</select>
	<?php
	}

	/*
	 * output Credit Cards select box
	 */
	public static function credit_cards($selected = '')
	{
		global $wpdb;

		$cards = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'dict_credit_cards');
	?>
		<select name="credit-cards" class="select-box-it form-control">
			<option value=""><?php _e('Select one', 'iii-dictionary') ?></option>
			<?php foreach($cards as $card) : ?>
				<option value="<?php echo $card->id ?>"<?php echo $selected == $card->id ? ' selected' : '' ?>><?php echo $card->name ?></option>
			<?php endforeach ?>
		</select>
	<?php
	}

	/*
	 * output User's Credit Cards select box
	 */
	public static function user_credit_cards($selected = '')
	{
		global $wpdb;

		$cards = $wpdb->get_results('SELECT uc.*, c.name FROM ' . $wpdb->prefix . 'dict_user_credit_cards AS uc
									 JOIN ' . $wpdb->prefix . 'dict_credit_cards AS c ON c.id = uc.card_type_id
									 WHERE exp_date > NOW() AND user_id = ' . get_current_user_id());
	?>
		<select name="user-credit-cards" class="select-box-it form-control">
			<option value=""><?php _e('Select one', 'iii-dictionary') ?></option>
			<?php foreach($cards as $card) : ?>
				<option value="<?php echo $card->id ?>"<?php echo $selected == $card->id ? ' selected' : '' ?>><?php echo $card->name . ' &mdash; ' . $card->display_card_number ?></option>
			<?php endforeach ?>
		</select>
	<?php
	}

	/*
	 * menu language switcher
	 *
	 */
	public static function sel_lang_switcher()
	{
		$langs = array(
			'en' 	=> 'English',
			'ja' 	=> '日本語',
			'ko' 	=> '한국어',
			'vi' => 'Tiếng Việt',
			'zh' 	=> '中文',
			'zh-tw' => '中國'
		);

		$cur_lang = get_short_lang_code();
?>
		<div id="lang-switcher-block" class="hidden-xs">
			<select class="select-box-it select-sapphire" id="lang-switcher">
				<?php foreach($langs as $code => $lang) : ?>
					<option value="<?php echo is_math_panel() ? str_replace('://', '://math.', site_url()) : site_url(); echo '/' . $code . '/' ?>"<?php echo $cur_lang == $code ? ' selected' : '' ?>><?php echo $lang ?></option>
				<?php endforeach ?>
			</select>
		</div>
<?php
	}

	/*
	 * language type
	 *
	 */
	public static function language_type($select)
	{
		$langs = array(
			'en' 	=> 'English',
			'ja' 	=> '日本語',
			'ko' 	=> '한국어',
			'vi' => 'Tiếng Việt',
			'zh' 	=> '中文',
			'zh-tw' => '中國'
		);

		//$cur_lang = get_short_lang_code();
?>
		<select name="language_type" class="form-control language_type select-box-it">
			<?php foreach($langs as $code => $lang) : ?>
				<option value="<?php echo $code; ?>"<?php echo $select == $code ? ' selected' : '' ?>><?php echo $lang ?></option>
			<?php endforeach ?>
		</select>
<?php
	}

	/*
	 * subscribe dictionary popup
	 *
	 * @param mixed $dictionary
	 *
	 */
	public static function subscribe_dictionary_popup($dictionary, $search_count = false, $number_of_times = 0, $is_dictionary_subscribed = false)
	{
		$blocked = false;
		if($search_count && $_SESSION['remind_count'][$dictionary] >= $number_of_times) {
			$blocked = true;
		}
	?>
		<div id="subscribe-modal-dialog" class="modal fade modal-red-brown subscribe-modal" aria-hidden="true"<?php echo $blocked ? ' data-backdrop="static"' : '' ?>>
			<div class="modal-dialog">
			  <div class="modal-content">
				<div class="modal-header">           
					<h3><?php _e('Please subscribe to this product', 'iii-dictionary') ?>
						<?php if($search_count) : ?>
							<?php if(!$blocked) : ?>
								<small><?php printf(__('Welcome! You get %s words free!', 'iii-dictionary'), $number_of_times) ?></small>
								<a href="#" data-dismiss="modal" aria-hidden="true" class="close"></a>
							<?php else : ?>
								<small><?php printf(__('You have tried %s words. Did you like it?', 'iii-dictionary'), $number_of_times) ?></small>
							<?php endif ?>
						<?php else : ?>
							<a href="#" data-dismiss="modal" aria-hidden="true" class="close"></a>
						<?php endif ?>
					</h3>
				</div>
				<div class="modal-body">
					<?php switch($dictionary) :

							case 'elearner':
							case 1: ?>

							<div class="cover-thumb">
								<img src="<?php echo get_template_directory_uri(); ?>/library/images/learner-cover-small.png" alt="">
							</div>
							<div class="popup-content-header">
								<h3 style="color: #00fff3"><?php _e('Why subscribe?', 'iii-dictionary') ?></h3>
								<ul class="ul-bullet-style4">					
									<li><?php _e('You can look up five words in the dictionary, then every additional word searched will bring up this pop-up untill you subscribe.', 'iii-dictionary') ?></li>
									<li><?php _e('Get the latest updates; additional features', 'iii-dictionary') ?></li>
								</ul>
							</div>
							<div class="popup-content-body">
								<div class="hr-line"></div>
								<h3 style="color: #00fff3"><?php _e('Features', 'iii-dictionary') ?></h3>
								<ul class="ul-bullet-style4">
									<li><?php _e('More than <span class="semi-bold">22,000</span> idioms, verbal collocations, and commonly used phrases from American and British English.', 'iii-dictionary') ?></li>
									<li><?php _e('More than <span class="semi-bold">160,000</span> example sentences the most of any learner\'s dictionary.', 'iii-dictionary') ?></li>
									<li><?php _e('<span class="semi-bold">100,000</span> words and phrases with <span class="semi-bold">3,000</span> core vocabulary words identified.', 'iii-dictionary') ?></li>
									<li><?php _e('More than <span class="semi-bold">12,000</span> usage labels, notes, and paragraphs.', 'iii-dictionary') ?></li>
									<li><?php _e('<span class="semi-bold">33,000</span> IPA pronunciations.', 'iii-dictionary') ?></li>
								</ul>
							</div>

						<?php break;

							case 'collegiate':
							case 2: ?>

							<div class="cover-thumb">
								<img src="<?php echo get_template_directory_uri(); ?>/library/images/collegiate-cover-small.png" alt="">
							</div>
							<div class="popup-content-header">
								<h3 style="color: #ff8787"><?php _e('Why subscribe?', 'iii-dictionary') ?></h3>
								<ul class="ul-bullet-style4">					
									<li><?php _e('You can look up five words in the dictionary, then every additional word searched will bring up this pop-up untill you subscribe.', 'iii-dictionary') ?></li>
									<li><?php _e('Get the latest updates; additional features', 'iii-dictionary') ?></li>
								</ul>
							</div>
							<div class="popup-content-body">
								<div class="hr-line"></div>
								<h3 style="color: #ff8787"><?php _e('Features', 'iii-dictionary') ?></h3>
								<ul class="ul-bullet-style4">
									<li><?php _e('Over <span class="semi-bold">275,000</span> Synonyms &amp; related words.', 'iii-dictionary') ?></li>
									<li><?php _e('Over <span class="semi-bold">115,000</span> Audio pronunciations.', 'iii-dictionary') ?></li>
									<li><?php _e('Over <span class="semi-bold">225,000</span> Definitions.', 'iii-dictionary') ?></li>
									<li><?php _e('Over <span class="semi-bold">700</span> Illustrations.', 'iii-dictionary') ?></li>
									<li><?php _e('Deluxe audio edition.', 'iii-dictionary') ?></li>
									<li><?php _e('Faster search with high-performance database engine.', 'iii-dictionary') ?></li>
								</ul>
							</div>
							<a href="#dic-donwload" id="click-dic-donwload" data-toggle="modal" style="display: none;"></a>
						<?php break;

							case 'medical':
							case 3: ?>

							<div class="cover-thumb">
								<img src="<?php echo get_template_directory_uri(); ?>/library/images/medical-cover-small.png" alt="">
							</div>
							<div class="popup-content-header">
								<h3 style="color: #a9c5ff"><?php _e('Why subscribe?', 'iii-dictionary') ?></h3>
								<ul class="ul-bullet-style4">					
									<li><?php _e('You can look up five words in the dictionary, then every additional word searched will bring up this pop-up untill you subscribe.', 'iii-dictionary') ?></li>
									<li><?php _e('Get the latest updates; additional features', 'iii-dictionary') ?></li>
								</ul>
							</div>
							<div class="popup-content-body">
								<div class="hr-line"></div>
								<h3 style="color: #a9c5ff"><?php _e('Features', 'iii-dictionary') ?></h3>
								<ul class="ul-bullet-style4">
									<li><?php _e('Over <span class="semi-bold">59,000</span> entries explain today\'s most widely used health-care terms.', 'iii-dictionary') ?></li>
									<li><?php _e('More than <span class="semi-bold">8,000</span> example phrases show how words are used in context.', 'iii-dictionary') ?></li>
									<li><?php _e('Affordable quick reference.', 'iii-dictionary') ?></li>
									<li><?php _e('Accessible guide to medical language.', 'iii-dictionary') ?></li>
									<li><?php _e('Faster search with high-performance database engine.', 'iii-dictionary') ?></li>
									<li><?php _e('Unmatched quality from the reference experts at Merriam-Webster.', 'iii-dictionary') ?></li>
								</ul>
							</div>

						<?php break;

							case 'intermediate':
							case 4: ?>

							<div class="cover-thumb">
								<img src="<?php echo get_template_directory_uri(); ?>/library/images/intermediate-cover-small.png" alt="">
							</div>
							<div class="popup-content-header">
								<h3 style="color: #7ff36f"><?php _e('Why subscribe?', 'iii-dictionary') ?></h3>
								<ul class="ul-bullet-style4">					
									<li><?php _e('You can look up five words in the dictionary, then every additional word searched will bring up this pop-up untill you subscribe.', 'iii-dictionary') ?></li>
									<li><?php _e('Get the latest updates; additional features', 'iii-dictionary') ?></li>
								</ul>
							</div>
							<div class="popup-content-body">
								<div class="hr-line"></div>
								<h3 style="color: #7ff36f"><?php _e('Features', 'iii-dictionary') ?></h3>
								<ul class="ul-bullet-style4">
									<li><?php _e('Nearly <span class="semi-bold">70,000</span> entries including new words and definitions from the fields of science, technology, entertainment, and health.', 'iii-dictionary') ?></li>
									<li><?php _e('More than <span class="semi-bold">22,000</span> usage examples.', 'iii-dictionary') ?></li>
									<li><?php _e('More than <span class="semi-bold">1,000</span> illustrations.', 'iii-dictionary') ?></li>
									<li><?php _e('Abundant word history paragraphs and synonym paragraphs.', 'iii-dictionary') ?></li>
									<li><?php _e('Written especially for the needs of students grades <span class="semi-bold">6-8</span>, ages <span class="semi-bold">11-14</span>', 'iii-dictionary') ?></li>
								</ul>
							</div>

						<?php break;

							case 'elementary':
							case 5: ?>

							<div class="cover-thumb">
								<img src="<?php echo get_template_directory_uri(); ?>/library/images/elementary-cover-small.png" alt="">
							</div>
							<div class="popup-content-header">
								<h3 style="color: #ffaa65"><?php _e('Why subscribe?', 'iii-dictionary') ?></h3>
								<ul class="ul-bullet-style4">					
									<li><?php _e('You can look up five words in the dictionary, then every additional word searched will bring up this pop-up untill you subscribe.', 'iii-dictionary') ?></li>
									<li><?php _e('Get the latest updates; additional features', 'iii-dictionary') ?></li>
								</ul>
							</div>
							<div class="popup-content-body">
								<div class="hr-line"></div>
								<h3 style="color: #ffaa65"><?php _e('Features', 'iii-dictionary') ?></h3>
								<ul class="ul-bullet-style4">
									<li><?php _e('Over <span class="semi-bold">36,000</span> fully revised entries.', 'iii-dictionary') ?></li>
									<li><?php _e('Expanded usage examples include more than <span class="semi-bold">1,300</span> quotes from classic and contemporary children\'s literature.', 'iii-dictionary') ?></li>
									<li><?php _e('<span class="semi-bold">250</span> word history paragraphs and over <span class="semi-bold">130</span> synonym paragraphs.', 'iii-dictionary') ?></li>
									<li><?php _e('More than <span class="semi-bold">900</span> new, colorful illustrations, photographs, and diagrams.', 'iii-dictionary') ?></li>
									<li><?php _e('Essential dictionary for children grades <span class="semi-bold">3-5</span>, ages <span class="semi-bold">8-11</span>', 'iii-dictionary') ?></li>
								</ul>
							</div>

						<?php break;

						endswitch ?>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-sm-6">
							<a href="<?php echo locale_home_url() ?>/?r=manage-subscription#2" class="btn btn-block orange confirm"><span class="icon-issue2"></span><?php _e('Subscribe now', 'iii-dictionary') ?></a>
						</div>
						<div class="col-sm-6">
							<?php if($blocked) : ?>
								<a href="<?php echo locale_home_url() ?>" class="btn btn-block grey confirm"><span class="icon-goto"></span><?php _e('Homepage', 'iii-dictionary') ?></a>
							<?php else : ?>
								<a href="#" data-dismiss="modal" class="btn btn-block grey confirm"><span class="icon-cancel"></span><?php _e('Not now', 'iii-dictionary') ?></a>
							<?php endif ?>
						</div>
					</div>
				</div>
			  </div>
			</div>
		</div>
	<?php
	}
	
	/*
	 * display messages in $_SESSION['message'] using modal
	 */
	public static function ik_site_messages()
	{
		$messages = ik_get_message_queue();
		
		$other 	  = !empty($messages) ? ik_get_other_queue($messages) : array();
		if(!empty($messages)) : ?>
			<div class="modal fade modal-red-brown" id="site-messages-modal" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
					<!-- <div class="modal-header">
					<a href="#" data-dismiss="modal" aria-hidden="true" class="close"></a>
					<h3 class="modal-title" id="myModalLabel"><?php _e('Messages', 'iii-dictionary') ?></h3>
					</div> -->
					<div class="modal-body">
						<div class="row">
							<div class="col-xs-12">
								<?php foreach($messages as $msg) : ?>
									<div class="<?php echo $msg->type ?>-message">
										<?php if(empty($msg->label)) : ?>
											<strong><?php echo $msg->msg ?> </strong>
										<?php else : ?>
											<strong><?php echo $msg->label ?></strong>: <?php echo $msg->msg ?>
										<?php endif ?>
									</div>
								<?php endforeach ?>
							</div>
							<img class="icon-close-classes-created" style="top: 25%" src="<?php echo get_template_directory_uri(); ?>/library/images/close_white.png">
						</div>
					</div>
					<?php if(!empty($other)) : ?>
						<?php
							switch($other['order']) {
								case 1 : MWHtml::get_first_assign($other);  break;
								case 2 : MWHtml::auto_active_code_dic($other); break;
							}	
						?>	
					<?php endif ?>
				</div>
			  </div>
			</div>
			<script>(function($){ $(function(){ $("#site-messages-modal").modal("show"); }); })(jQuery);</script>
	<?php endif;
	}

	/*
	 * lock a page
	 */
	public static function ik_lockpage_dialog()
	{
		if(!empty($_SESSION['lock-page'])) : ?>
			<div class="lockpage-dialog-container">
				<div class="modal-backdrop in"></div>
				<div class="ik-dialog">
					<div class="ik-dialog-content">
					  <div class="ik-dialog-header">
						<h3 class="ik-dialog-title"><?php echo $_SESSION['lock-page']['title'] ?></h3>
					  </div>
					  <div class="ik-dialog-body">
						<div class="row">
							<div class="col-sm-12 form-group">
								<?php echo $_SESSION['lock-page']['body'] ?>
							</div>
							<div class="col-sm-3 col-sm-offset-9">
								<a href="<?php echo $_SESSION['lock-page']['return_url'] ?>" class="btn btn-default btn-block orange"><?php _e('OK', 'iii-dictionary') ?></a>
							</div>
						</div>
					  </div>
					</div>
				</div>
			</div>
		<?php $_SESSION['lock-page'] = null;
		endif;
	}
	/*
	* get all sel assigment.
	* @param : as two function math/english above
	*/
	public static function get_sel_assignments($selected = '', $get_form = false, $questions = array(), $first_option = '', $name = 'assignments', $class = '', $id = 'assignments', $vocab_option = true)
	{
		global $wpdb;

		$types = $wpdb->get_results(
			'SELECT a.id, has.name
			 FROM ' . $wpdb->prefix . 'dict_homework_assignments AS a
			 JOIN ' . $wpdb->prefix . 'dict_homework_assignment_langs AS has ON has.assignment_id = a.id
			 WHERE  lang = \'' . get_short_lang_code() . '\''
		);

		$class = $class == '' ? '' : ' ' . $class;
		$html = '';

?>
		<select class="select-box-it<?php echo $class ?>" name="<?php echo $name ?>" id="<?php echo $id ?>">
			<?php if($first_option != '') : ?>
				<option value=""><?php echo $first_option ?></option>
			<?php endif ?>
			<?php foreach($types as $type) :
				if($type->id != ASSIGNMENT_VOCAB_BUILDER && $type->id != ASSIGNMENT_REPORT) : ?>
					<option value="<?php echo $type->id ?>"<?php echo $selected == $type->id ? ' selected' : '' ?>><?php echo $type->name ?></option>
				<?php else :
					if(!is_admin_panel() && $vocab_option) : ?>
						<option value="<?php echo $type->id ?>"<?php echo $selected == $type->id ? ' selected' : '' ?>><?php echo $type->name ?></option>
					<?php endif;
				endif ?>
			<?php endforeach ?>
		</select>

<?php 
		return $html;
	}
	
	/* get expire subscription for home.
	 * @param
	 * @result
	 */
	public static function get_exp_subscription() {
		$current_user_id = get_current_user_id();
		$current_page = max( 1, get_query_var('page'));
		$filter = get_page_filter_session();
		if(empty($filter))
		{
			$filter['items_per_page'] = 10;
			$filter['offset'] = $filter['items_per_page'] * ($current_page - 1);
		}
		else {
			$filter['offset'] = $filter['items_per_page'] * ($current_page - 1);
		}

		set_page_filter_session($filter);
		$filter['offset'] = 0;
		$filter['items_per_page'] = 99999999;
		$user_subscriptions = MWDB::get_user_subscriptions($current_user_id, $filter);
		$total_pages = ceil($user_subscriptions->total / $filter['items_per_page']);

		$pagination = paginate_links(array(
			'format' => '?page=%#%',
			'current' =>  $current_page,
			'total' => $total_pages
		));
		$cart_items = get_cart_items();
?>
	<form id="main-form" method="post" action="">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-sapphire">
					<div class="row">
						<div class="col-sm-12">
							<div class="scroll-list2" style="max-height: 500px">
								<table class="table table-striped table-condensed ik-table1 ik-table-break-all text-center" id="user-subscriptions">
									<thead>
										<tr>
											<th><?php _e('Type', 'iii-dictionary') ?></th>
											<th class="hidden-xs"><?php _e('No. of Students', 'iii-dictionary') ?></th>
											<th class="hidden-xs"><?php _e('No. of Users', 'iii-dictionary') ?></th>
											<th class="hidden-xs"><?php _e('Sub. End', 'iii-dictionary') ?></th>
											<th class="hidden-xs"><?php _e('Dictionary', 'iii-dictionary') ?></th>
											<th class="hidden-xs"><?php _e('Group', 'iii-dictionary') ?></th>
											<th></th>
										</tr>
									</thead>
									<tfoot>
										<tr><td colspan="8"><?php echo $pagination ?></td></tr>
									</tfoot>
									<tbody>
										<?php if(empty($user_subscriptions->items)) : ?>
											<tr><td colspan="8"><?php _e('You haven\'t subscribed yet.', 'iii-dictionary') ?></td></tr>
										<?php else : ?>
											<?php foreach($user_subscriptions->items as $code) : ?>
												<tr<?php echo $code->expired_on < date('Y-m-d', time()) ? ' class="text-muted"' : '' ?>>
													<td><?php if(!$code->inherit) : ?>
															<?php echo $code->type ?><?php echo in_array($code->typeid, array(SUB_SAT_PREPARATION, SUB_MATH_SAT_I_PREP, SUB_MATH_SAT_II_PREP)) ? ' - ' . $code->sat_class : '' ?>
														<?php else : ?>
															<?php echo $code->type ?>
														<?php endif ?>
													</td>
													<?php $date1 = new DateTime();
														$date2 = new DateTime($code->expired_on);
														$interval = $date1->diff($date2);
														$_expire = check_exp_subscription(date_diff($date1, $date2)->format('%R %a'));
														$months_left = $interval->d > 0 ? $interval->m + 1 : $interval->m;
														$checked_out_state = '';
														foreach($cart_items as $item) {
															if($item->sub_id == $code->id) {
																$checked_out_state = ' disabled';
															}
														}
													?>
													<td class="hidden-xs"><?php echo in_array($code->typeid, array(SUB_TEACHER_TOOL, SUB_TEACHER_TOOL_MATH)) ? $code->number_of_students : 'N/A' ?></td>
													<td class="hidden-xs"><?php echo in_array($code->typeid, array(SUB_DICTIONARY, SUB_SELF_STUDY, SUB_SELF_STUDY_MATH)) ? $code->number_of_students : 'N/A' ?></td>
													<td class="hidden-xs<?php echo $_expire ? ' omg_expire': '';?>"><span><?php echo ik_date_format($code->expired_on) ?></span></td>
													<td class="hidden-xs"><?php echo $code->dictionary ?></td>
													<td class="hidden-xs"><?php echo is_null($code->group_name) ? 'N/A' : $code->group_name ?></td>
													<td data-subid="<?php echo $code->id ?>" data-type="<?php echo $code->typeid ?>" data-did="<?php echo $code->dictionary_id ?>" data-size="<?php echo $code->number_of_students ?>" data-months="<?php echo $months_left ?>"<?php echo !is_null($code->group_name) ? ' data-group="' . $code->group_name . '"' : '' ?> data-sat-class="<?php echo $code->sat_class ?>" data-sat-class-id="<?php echo $code->sat_class_id ?>">
														<?php if(!$code->inherit) : ?>
															<?php if(in_array($code->typeid, array(SUB_TEACHER_TOOL_MATH, SUB_TEACHER_TOOL))) : ?>
																<button type="button" class="btn btn-default btn-block btn-tiny grey extend-sub-btn" data-task="add"<?php echo $checked_out_state ?>><?php _e('Add Members', 'iii-dictionary') ?></button>
															<?php endif ?>
															<button type="button" class="btn btn-default btn-block btn-tiny grey extend-sub-btn" <?php echo $checked_out_state ?>><?php _e('Renew Subscription', 'iii-dictionary') ?></button>
															<a href="<?php echo locale_home_url() ?>/?r=view-subscription&amp;cid=<?php echo $code->id ?>" class="btn btn-default btn-block btn-tiny grey"><?php _e('Detail', 'iii-dictionary') ?></a>
														<?php endif ?>
													</td>
												</tr>
											<?php endforeach ?>
										<?php endif ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
<?php 
	}
	/* get sub & mes to notice for user
	 * @param : null
	 * @result : structure html 
	 */
	public static function notice_sub_mes() {
		$id_msg = MWDB::get_id_display_at_login();
?>
			
<?php if(!empty($id_msg) && is_user_logged_in() ) : ?>
			<div id="display-at-login-dialog" class="modal fade modal-red-brown" aria-hidden="true">
				<div class="modal-dialog">
				  <div class="modal-content">
					<div class="modal-header">
						<a href="#" data-dismiss="modal" aria-hidden="true" class="close"></a>
						<h3><?php _e('Messages from Support', 'iii-dictionary') ?></h3>
					</div>
					<div class="modal-body ">
						<?php 
							$msg = MWDB::get_received_private_message($id_msg);
							echo $msg->message;
						?>
					</div>
					<div class="modal-footer">
						<div class="row">
							<div class="col-sm-6 col-sm-offset-6">
								<button type="button" id="submit-display-at-login" class="btn btn-block orange confirm"><span class="icon-check"></span><?php _e('OK', 'iii-dictionary') ?></button>
							</div>
						</div>
					</div>
				  </div>
				</div>
			</div>
<?php endif ?>
<?php if(is_home_page() && $_SESSION['notice-dialog'] == 1 && is_user_logged_in() ) : ?>
			<div id="current-subscription-dialog" class="modal fade modal-red-brown" aria-hidden="true">
				<div class="modal-dialog">
				  <div class="modal-content">
					<div class="modal-header omg_home-sub-header">
						<a href="#" data-dismiss="modal" aria-hidden="true" class="close"></a>
						<h2><?php _e('Current Subscription', 'iii-dictionary') ?></h2>
						<p><?php printf(__('Your subscription for the item below will expire in 10 days %s Would you like to extend your subscription now?', 'iii-dictionary'), '<br />') ?></p>
					</div>
					<div class="modal-body omg_home-sub-body">
						<div><?php MWHtml::get_exp_subscription();?></div>
					</div>
					
				  </div>
				</div>
			</div>

			<div id="message-from-support-dialog" class="modal fade modal-red-brown" aria-hidden="true">
				<div class="modal-dialog">
				  <div class="modal-content">
					<div class="modal-body omg_message-support">
						<div class="row">
							<div class="col-xs-12">
								<div class="row">
									<div class="col-sm-4">
										<h2><?php _e('Respone from ikLearn', 'iii-dictionary') ?></h2>
									</div>
									<div class="col-sm-6">
										<label><?php printf(__('You have a message from Support. %s Go to "Private Messages" under "My Account"'),'<br />') ?></label>
									</div>
									<div class="col-sm-2">
										<a href="<?php echo home_url() ?>/?r=private-messages">Check Now</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				  </div>
				</div>
			</div>
<?php endif ?>
	<script>
		//javscript reated to home
		//push modal 
		var is_prvm = '<?php echo check_message_user() ?>';
		var is_expr = '<?php echo $_SESSION['exp_sb'] ?>';
		var is_dpal = '<?php echo !empty($id_msg) ? 1 : 0; ?>';
		var is_id 	=  <?php echo !empty($id_msg) ? $id_msg : 0 ?>;
		var is_login = <?php echo is_user_logged_in() ? 1 : 0 ?>;
		var is_grouplist = <?php $get_url = explode('/', $_SERVER['REQUEST_URI']); echo $get_url[2] == 'grouplist' ? 1 : 0?>;
		var is_myc 		= <?php $router = get_route(); echo $router[0] == 'manage-your-class' ? 1 : 0 ?>;
		
		(function($) {
			var md_sub 	= $('#current-subscription-dialog');
			var md_mg  	= $('#message-from-support-dialog');
			var md_dpal = $('#display-at-login-dialog');
			if(is_dpal == '1') {
				md_dpal.modal('show');
				md_dpal.on('click', function() {
					if(is_expr == '1' && !md_dpal.data('bs.modal').isShown) {
						md_sub.modal('show');
						md_sub.on('click', function() {
							if(is_prvm == '1' && !md_sub.data('bs.modal').isShown) {
								md_mg.modal('show');
							}
						});
					}else{
						if(is_prvm == '1' && !md_dpal.data('bs.modal').isShown) {
							md_mg.modal('show');
						}
					}
				});
				
			}else if(is_expr == '1' && is_dpal == '0') {
				md_sub.modal('show');	
				md_sub.on('click', function() {
					if(is_prvm == '1' && !md_sub.data('bs.modal').isShown) {
						md_mg.modal('show');
					}
				});
			}else if(is_prvm == '1') {
				md_mg.modal('show');	
			}
			
			$("#submit-display-at-login").click(function() {
				$.post("<?php echo home_url() ?>/?r=ajax/status_msg", { id: is_id});
				md_dpal.find('a.close').trigger('click');
			});
			
			$(".join-class-lang-btn").on("click", function() {
				var get_jcid = $(this).attr('data-jcid');
				var get_free  = $(this).attr('data-free');
				
				if(is_login == 0) {
					$(location).attr('href','<?php echo locale_home_url() ?>/?r=login');
				}else {
					$('#data-join').val(get_jcid);
					if(get_free == 1) {
						$('#lang-form').submit();
					}else {
						var _gprice = $(this).parents('tr').find('td:eq(1)').text();
						$('#_gprice').text(_gprice);
						$('#require-pay-modal').modal();
						return false;
					}
				}
				
			});
			
			$(".lang-writing-btn").on('click',function() {
				var tthis = $('#language-writing-modal');
				tthis.find('.modal-body').html($(this).next().html());
				tthis.modal();
				return false;
			});
			
			
			$("#class-with-lang").on('click',function() {
				md_down(".md-lang");
				return false;
			});
			$(".md-close").on('click',function() {
				md_up(".md-lang");
				return false;
			});
			$(".md-myc-close").on('click',function() {
				md_up(".md-myc");
				return false;
			});
			
			function md_up(_md) {
				$(_md).slideUp('slow');
			}
			function md_down( _md) {
				$(_md).slideDown('slow');
			}
			
			if(is_grouplist == 1) {
				$('#class-with-lang').click();
				$('.md-lang').find(".md-close").unbind().attr('href', '<?php echo locale_home_url() ?>');
			}
			if(is_myc == 1) {
				md_down(".md-myc");
			}
			
		})(jQuery);
	</script>
<?php  
		$_SESSION['notice-dialog'] = null;
		$_SESSION['exp_sb'] = null;
	}
	
	/* get first practice/test when user join group
	 * @param id group in message
	 * @ result button html
	 */
	public static function get_first_assign($group_id) {
		
		$homeworks = is_first_assign($group_id['group_id']);
		$uref = rawurlencode(base64_encode(home_url() . $_SERVER['REQUEST_URI']));
		
		if(!empty($homeworks->items)) { 
			foreach($homeworks->items as $hw) {
				if(!$hw->finished || is_null($hw->finished)) {
					$practice_url = MWHtml::get_practice_page_url($hw->assignment_id) . '&amp;hid=' . $hw->hid;
					$homework_url = MWHtml::get_practice_page_url($hw->assignment_id) . '&amp;mode=homework&amp;hid=' . $hw->hid;
					$rp_url = $hw->for_practice ? $practice_url : $homework_url;
					$rp_url = !empty($uref) ? $rp_url . '&ref=' . $uref : $rp_url;
					$router  = get_route();
?>
        <div class="modal-footer">
				<div class="row">
                                    <div class="col-xs-5 col-xs-offset-2" >
						<a href="<?php echo $rp_url ?>" class="btn btn-block orange"><span class="icon-check"></span><?php _e('Start Now', 'iii-dictionary') ?></a>
					</div>
					<div class="col-xs-5">
						<?php if($router[0] != 'manage-subscription') { ?>
							<a href="#" data-dismiss="modal" aria-hidden="true" class="btn btn-block grey"><span class="icon-cancel"></span><?php _e('Not Now', 'iii-dictionary') ?></a>
						<?php } else { ?>
							<a href="<?php echo home_url() ?>/?r=homework-status" class="btn btn-block grey"><span class="icon-cancel"></span><?php _e('Not Now', 'iii-dictionary') ?></a>
						<?php } ?>
					</div>
				</div>
			</div>
<?php
				}
			}
		}
	}
	
	/* button for user to automatic active code dictionary
	 * @param activate_code
	 * @return html
	 */
	public static function auto_active_code_dic($activate_code) {
?>
	<div class="modal-footer">
		<div class="row">
			<div class="col-xs-5 col-xs-offset-2">
				<button type="button" id="apply-credit-code" data-active='<?php echo $activate_code['activate_code'] ?>' class="btn btn-default btn-block orange"><span class="icon-check"></span><?php _e('Yes', 'iii-dictionary') ?></button>
			</div>
			<div class="col-xs-5">
				<a href="#" data-dismiss="modal" aria-hidden="true" class="btn btn-block grey"><span class="icon-cancel"></span><?php _e('Later', 'iii-dictionary') ?></a>
			</div>
		</div>
	</div>
<?php
	}
	
	/* get group with  assign lang
	 * @param /lang in url
	 * @result html
	*/
	public static function get_list_lang() {
		$_lang 						= get_short_lang_code();
		$is_math 					= is_math_panel();
		$current_page 				= max( 1, get_query_var('page'));
		$filter['offset'] 			= 0;
		$filter['items_per_page'] 	= 99999999;
		$filter['group_type'] 		= GROUP_CLASS;
		$filter['lang'] 			= is_math_panel() ? get_short_lang_code() . '-math' : get_short_lang_code() . '-en';
		$filter['orderby'] 			= 'ordering';
		$filter['order-dir'] 		= 'ASC';
		$groups 					= MWDB::get_groups($filter, $filter['offset'], $filter['items_per_page']);
		$uref 						= rawurlencode(base64_encode(home_url() . $_SERVER['REQUEST_URI']));
		$_mark 						= ($_lang != 'ja') ? '$' : '';
		/*
		$total_pages = ceil($groups->total / $filter['items_per_page']);

		$pagination = paginate_links(array(
			'format' => '?page=%#%',
			'current' =>  $current_page,
			'total' => $total_pages
		));
		*/
		
?>
		<form id="lang-form" method="post" action="">
			<div class="md-lang" >
				<div class="md-lang-content">
					<div class="md-header md-header-<?php echo $is_math ? 'math' : 'english' ?>">
						<a href="#" class="md-close"><?php _e('Close X', 'iii-dictionary') ?></a>
					</div>
					<div class="md-body">
						<div class="row">
							<div class="col-sm-12 md-select-<?php echo $is_math ? 'math' : 'english' ?>">
								<p class="md-select-p"><span class="arrow"></span><?php _e('Select a lesson and click Join to start your lesson', 'iii-dictionary') ?></p>
							</div>
							<div class="col-sm-12 md-table md-table-<?php echo $is_math ? 'math' : 'english' ?>">
								<div class="scroll-list2 md-cl-<?php echo $is_math ? 'math' : 'english' ?> scrollbar-white md-eng-math">
									<table class="table table-striped table-condensed ik-table1 text-center md-tbody-<?php echo $is_math ? 'math' : 'english' ?>">
										<thead>
											<tr>
												<th><?php _e('Group Name', 'iii-dictionary') ?></th>
												<th><?php ($_lang != 'ja') ? _e('Price', 'iii-dictionary') : _e('Point', 'iii-dictionary') ?></th>
												<th><?php _e('Course Name', 'iii-dictionary') ?></th>
												<th><?php _e('Detail', 'iii-dictionary') ?></th>
												<th><?php _e('Join', 'iii-dictionary') ?></th>
												<th><?php _e('No.', 'iii-dictionary') ?></th>
											</tr>
										</thead>
										<tbody>
											<?php if(empty($groups->items)) : ?>
												<tr class='text-center'><td colspan="6"><?php _e('No Class at his moment', 'iii-dictionary') ?></td></tr>
											<?php else :
												foreach($groups->items as $item) : $get_stg = MWDB::get_something_in_group($item->id); ?>
													<tr>
														<td><?php echo $item->name ?></td>
														<td><?php echo ($item->price != 0) ? $_mark .''. $item->price : 'Free' ?></td>
														<td class="text-left"><?php echo $item->content ?></td>
														<td><a href="#" class="prevent_detail-btn-<?php echo $is_math ? 'math' : 'english' ?> hidden-div lang-writing-btn"><?php _e('detail', 'iii-dictionary') ?></a><div><?php echo $item->detail ?></div></td>
														<td>
															<?php if(empty($get_stg->step_of_user)) { ?>
																<a href="#" data-free=<?php echo ( $item->price == 0 ) ? '1' : '0' ?>  data-jcid="<?php echo $item->id ?>"  class="prevent_detail-btn-<?php echo $is_math ? 'math' : 'english' ?> join-class-lang-btn"><?php _e('Join', 'iii-dictionary') ?></a>
															<?php }else { 
																$practice_url = MWHtml::get_practice_page_url($get_stg->step['assg']) . '&amp;hid=' . $get_stg->step['id'];
																$homework_url = MWHtml::get_practice_page_url($get_stg->step['assg']) . '&amp;mode=homework&amp;hid=' . $get_stg->step['id'];
																$rp_url = $get_stg->step['prt'] ? $practice_url : $homework_url;
																$rp_url = !empty($uref) ? $rp_url . '&ref=' . $uref : $rp_url;
															?>
																<a href="<?php echo $rp_url ?>" class="prevent_detail-btn-<?php echo $is_math ? 'math' : 'english' ?> "><?php _e('Continue', 'iii-dictionary') ?></a>
															<?php } ?>
														</td>
														<td><?php echo !empty($get_stg->step_of_user) ?  $get_stg->step_of_user['completed_homework'] . '/' . $get_stg->total_hw['total_hw']   : 0 . '/' . $get_stg->total_hw['total_hw']   ?></td>
													</tr>
											<?php endforeach;
											endif 
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="modal fade modal-small modal-md-color-<?php echo $is_math ? 'math' : 'english' ?>" id="language-writing-modal" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header md-modal-header">
						<a href="#" data-dismiss="modal" aria-hidden="true" class="md-modal-close">X</a>
						<p class="md-modal-title"><?php _e('Class Detail', 'iii-dictionary') ?></p>
					  </div>
					  <div class="modal-body"></div>
					  <div class="modal-footer">
						<div class="row">
							<div class="col-xs-5">
								<a href="#" data-dismiss="modal" aria-hidden="true" class="btn btn-block orange"><?php _e('Close', 'iii-dictionary') ?></a>
							</div>
						</div>
					  </div>
					</div>
				</div>
			</div>
			
			<div id="require-pay-modal" class="modal fade modal-small modal-md-color-<?php echo $is_math ? 'math' : 'english' ?>" aria-hidden="true">
				<div class="modal-dialog">
				  <div class="modal-content">
					<div class="modal-header  md-modal-header">
						<a href="#" data-dismiss="modal" aria-hidden="true" class="md-modal-close">X</a>
						<p class="md-modal-title"><?php _e('Messages', 'iii-dictionary') ?></p>
					</div>
					<div class="modal-body">
						<?php _e('Please purchase points and pay by the points.','iii-dictionary') ?>
						<?php printf(__('%s- You need %s.','iii-dictionary'),'<br />','<span id="_gprice"></span>') ?>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-block orange"><?php _e('OK', 'iii-dictionary') ?></button>
					</div>
				  </div>
				</div>
			</div>
			<input type="hidden" name="data-join" id="data-join" value="" />
		</form>
<?php
	}
	
	public static function manage_your_class() {
?>
		<div class="md-myc-content">
			<div class="md-myc-header container">
				<a href="#" data-dismiss="modal" aria-hidden="true" class="close" style="padding:5px 10px">X</a>
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<h2><?php _e('Create a Group or Class, and Manage your Class', 'iii-dictionary') ?></h2>
					</div>
				</div>
			</div>
			<div class="md-myc-body container" style="padding-top: 20px;">
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<div class="row">
							<div class="col-md-7 omg-mrt20px ">
								<div class="row">
									<div class="col-md-2"><span class="md-myc-step"><?php _e('step 1', 'iii-dictionary') ?></span></div>
									<div class="col-md-10">
										<?php _e('Create a group (class) under', 'iii-dictionary') ?>
										<a href="<?php echo locale_home_url() ?>/?r=create-group" class='omg_yellow-link'><?php _e('"Teacher &#8594; Create A group or Class."','iii-dictionary')?></a>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-7 omg-mrt20px ">
								<div class="row">
									<div class="col-md-2"><span class="md-myc-step"><?php _e('step 2', 'iii-dictionary') ?></span></div>
									<div class="col-md-10">
										<?php  printf( __('Send "assignment" to the class/group from %s', 'iii-dictionary'), "<br/>") ?>
										<a href="<?php echo locale_home_url() ?>/?r=homework-assignment" class='omg_yellow-link'><?php _e('"Teacher &#8594; Homework Assignment." ','iii-dictionary')?></a>
										<?php printf(__('"Assignments" are worksheets, and it can be sent as "practice mode" or "test mode". In test mode. students will not see 
													the answer until it has been graded. In practice mode, the worksheet will not be graded.', 'iii-dictionary'),'<br />','<br />'); ?>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-7 omg-mrt20px ">
								<div class="row">
									<div class="col-md-2"><span class="md-myc-step"><?php _e('step 3', 'iii-dictionary') ?></span></div>
									<div class="col-md-10">
										<?php _e('Give group name and password to students and so they can join the group.', 'iii-dictionary'); ?>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-7 omg-mrt20px ">
								<div class="row">
									<div class="col-md-2"><span class="md-myc-step"><?php _e('step 4', 'iii-dictionary') ?></span></div>
									<div class="col-md-10">
										<?php _e('Students see the assignment at ', 'iii-dictionary') ?>
										<a href="<?php echo locale_home_url() ?>/?r=homework-status" class='omg_yellow-link'><?php _e('"Student &#8594; Online Learning."','iii-dictionary')?></a>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-7 omg-mrt20px ">
								<div class="row">
									<div class="col-md-2"><span class="md-myc-step"><?php _e('step 5', 'iii-dictionary') ?></span></div>
									<div class="col-md-10">
										<?php _e('When students finish the assignment, the teacher can see the auto-graded  assignment at ', 'iii-dictionary') ?>
										<a href="<?php echo locale_home_url() ?>/?r=teachers-box" class='omg_yellow-link'><?php _e('"Teacher &#8594; Manage Your Class."','iii-dictionary')?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="md-myc-footer container">
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<div class="row">
							<div class="col-md-7 omg-mrt20px ">
								<div class="row">
									<div class="col-md-2"><span class="md-myc-touch">&nbsp;</span></div>
									<div class="col-md-10 myc-footer-dis">
										<?php _e('Teachers  may use ready-made worksheets as assignments, or create their own worksheet (in English only). "English Writing" assignments will
												not be auto-graded. Teachers can manually grade "English Writing" assignments if they wish to do so. For "project" assignments, students can
												send their completed "project" file to the teacher.', 'iii-dictionary'); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	
	public static function get_main_folder_name($name = 'main-folder-media', $class = '', $id = 'main-folder-media', $dic = 0) {
		$theme_root = get_theme_root();
?>
		<select class="form-control selectboxit select-box-it<?php echo $class ?>" name="<?php echo $name ?>" id="<?php echo $id ?>">
			<option value="" ><?php _e('Select a directory', 'iii-dictionary')?></option>
			<?php if($dic == 1) { ?> <option value="media" ><?php _e('root', 'iii-dictionary')?></option> <?php } ?>
			<?php foreach(glob('media/*', GLOB_ONLYDIR) as $data)  : ?>
				<option value="<?php echo $data  ?>" <?php if($id == 's_main_folder' && $_SESSION['media']['main-dic'] == $data) echo "selected"; ?>><?php echo $dic == 1 ? ' &rarr; ' . basename($data) : basename($data)  ?></option>
			<?php endforeach ?>
		</select>
<?php 
	}
	
	public static function get_sub_folder_name($name = 'sub-folder-media', $class = '', $id = 'sub-folder-media') {
?>
		<select class="select-box-it<?php echo $class ?>" name="<?php echo $name ?>" id="<?php echo $id ?>">
			<option value="" ><?php _e('Select a directory', 'iii-dictionary')?></option>
		</select>
<?php
	} 
	
	public static function list_folder_file($dir, $parent = '', $root = 0 , $sfile) {
		$scan 	= scandir($dir);
		$ignore = array('.','..');
		if(count($scan) > 2) {
			foreach($scan as $data) {
				if( !in_array($data, $ignore) ) {
					if(is_dir($dir . '/' . $data)) {
						MWHtml::list_folder_file($dir . '/' . $data, $dir . '/' . $data, 0, $sfile);
					}	
					else {
						if(empty($sfile)) { _END_:
?>	
							<tr>
								<td><?php echo $data ?></td>
								<td><?php echo $parent ?></td>
								<td><?php echo date("m/d/Y", time() -  @filemtime(utf8_decode($data)) )?></td>
							</tr>
<?php
						}else { if($sfile == $data) { $s_result = 1; goto _END_; } }
					}
				}
			}
		}
	}

}


