<?php


namespace Britzel\Form;


class Form
{

    public function create($formBuilder): string
    {
        $form = '';

        foreach ($formBuilder as $input => $options) {

            if ($input !== '_formTheme' && $input !== 'submit') {
                if (!isset($options['disabled']) || $options['disabled'] === false) {

                    if ($formBuilder['_formTheme']) {
                        $options['rowAttr']['class'] = $this->getClassTheme($formBuilder['_formTheme'], true) . ' ' . ($options['rowAttr']['class'] ?? '');
                        $options['attr']['class'] = $this->getClassTheme($formBuilder['_formTheme']) . ' ' . ($options['attr']['class'] ?? '');
                    }

                    if (isset($options['rowAttr'])) {
                        $form .= '<div';
	
	                    foreach ($options['rowAttr'] as $key => $value) {
		                    if ($this->optionRowIsValid($key))
		                        $form .= ' ' . $key . '="' . $value . '"';
	                    }

                        $form .= '>';
                    } else {
                        $form .= '<div>';
                    }
                    
                    if (isset($options['errors'])) {
	                    $form .= '<div class="' . ($options['helpAttr']['class'] ?? '') . '">';
	                    if (is_array($options['errors'])) {
		                    foreach ($options['errors'] as $value) {
			                    $form .= '<span>' . $value . '</span>';
		                    }
	                    }
                    }

                    if (isset($options['label'])) {
                        if ($options['label'] !== null)
                            $form .= '<label for="' . $input . '">' . $options['label'] . '</label>';
                    } else
                        $form .= '<label for="' . $input . '">' . ucfirst($input) . '</label>';

                    $form .= '<input type="' . $this->getType($options['type']) . '" name="' . $input . '"';

                    if (isset($options['attr'])) {
	                    foreach ($options['attr'] as $key => $value) {
		                    if ($this->optionIsValid($key))
			                    $form .= ' ' . $key . '="' . $value . '"';
	                    }
                    }

                    if (isset($options['value']))
                        $form .= ' value="' . $options['value'] . '"';

                    if (isset($options['placeholder']))
                        $form .= ' placeholder="' . $options['placeholder'] . '"';

                    if (!isset($options['required']) || $options['required'] !== false)
                        $form .= ' required';

                    $form .= '>';
	
	                if (!empty($options['help'])) {
						$form .= '<div class="' . ($options['helpAttr']['class'] ?? '') . '">';
						if (is_array($options['help'])) {
							foreach ($options['help'] as $value) {
								$form .= '<span>' . $value . '</span>';
							}
						}
	                }
	                
                    $form .= '</div>';

                }
            }

        }

        foreach ($formBuilder as $input => $options) {

            if ($input === 'submit') {

                if (isset($options['rowAttr']['class']))
                    $form .= '<div class="' . $options['rowAttr']['class'] . '">';

                $form .= '<button type="submit"';

                if ($options['attr']['class'])
                    $form .= ' class="' . $options['attr']['class'] . '"';

                $form .= '>' . $options['value'] . '</button></div>';
                $submit = 1;
            }

        }

        if (!isset($submit)) {
            $form .= '<button type="submit">submit</button>';
        }

        return $form;
    }

    private function getType(int $type): string
    {
        switch ($type) {
            case 2:
                return 'number';
            case 3:
                return 'email';
            case 4:
                return 'date';
            case 5:
                return 'password';
            case 6:
                return 'checkbox';
            case 7:
                return 'time';
            case 8:
                return 'file';
            case 9:
                return 'hidden';
            case 10:
                return 'submit';
            case 11:
                return 'color';
            case 12:
                return 'range';
            case 13:
                return 'search';
            case 14:
                return 'url';
            default:
                return 'text';
        }
    }

    private function getClassTheme(int $theme, bool $isRow = false): string
    {
        if ($isRow) {
            switch ($theme) {
                case FormBuilder::BOOTSTRAP4_THEME:
                    return 'form-group';
                default:
                    return '';
            }
        } else {
            switch ($theme) {
                case FormBuilder::BOOTSTRAP4_THEME:
                    return 'form-control';
                default:
                    return '';
            }
        }
    }
    
    private function optionIsValid(string $option) {
	    switch ($option) {
		    case 'id':
		    case 'class':
		    case 'min':
		    case 'max':
		    case 'minLength':
		    case 'maxLength':
		    case 'accept':
		    case 'alt':
		    case 'autofocus':
		    case 'pattern':
			    return true;
		    default:
			    return false;
	    }
    }
	
	private function optionRowIsValid(string $option) {
		switch ($option) {
			case 'id':
			case 'class':
				return true;
			default:
				return false;
		}
	}

}