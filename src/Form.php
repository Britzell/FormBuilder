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
            } elseif ($input === 'submit') {

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
            case 9:
                return 'hidden';
            case 10:
                return 'submit';
            default:
                return 'text';
        }
    }

}