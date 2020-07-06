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

                        if (isset($options['rowAttr']['class']))
                            $form .= ' class="' . $options['rowAttr']['class'] . '"';

                        $form .= '>';
                    } else {
                        $form .= '<div>';
                    }

                    if (isset($options['label'])) {
                        if ($options['label'] !== null)
                            $form .= '<label for="' . $input . '">' . $options['label'] . '</label>';
                    } else
                        $form .= '<label for="' . $input . '">' . ucfirst($input) . '</label>';

                    $form .= '<input type="' . $this->getType($options['type']) . '" name="' . $input . '"';

                    if (isset($options['attr'])) {
                        if (isset($options['attr']['class']))
                            $form .= ' class="' . $options['attr']['class'] . '"';
                    }

                    if (isset($options['placeholder']))
                        $form .= ' placeholder="' . $options['placeholder'] . '"';

                    $form .= '></div>';

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

}