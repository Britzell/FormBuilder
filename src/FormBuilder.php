<?php


namespace Britzel\Form;


class FormBuilder
{

    const TEXT_TYPE = 1;
    const NUMBER_TYPE = 2;
    const EMAIL_TYPE = 3;
    const DATE_TYPE = 4;
    const PASSWORD_TYPE = 5;
    const CHECKBOX_TYPE = 6;
    const TIME_TYPE = 7;
    const FILE_TYPE = 8;
    const HIDDEN_TYPE = 9;
    const SUBMIT_TYPE = 10;
    const COLOR_TYPE = 11;
    const RANGE_TYPE = 12;
    const SEARCH_TYPE = 13;
    const URL_TYPE = 14;

    const DEFAULT_THEME = 0;
    const BOOTSTRAP4_THEME = 1;

    private $entity;
    private $form;
    private $optionsToAll = [];

    public function __construct($entity, int $theme = 0)
    {
        $this->entity = $entity;
        $this->form['_formTheme'] = $theme;
        $this->getMethods();
        return $this;
    }

    private function getMethods(): array
    {
        $reflection = new \ReflectionClass($this->entity);
        foreach ($reflection->getMethods() as $method) {
            if (substr($method->name, 0, 3) === 'set' && $method->name !== 'setId') {
                $name = substr($method->name, 3);
                $name[0] = strtolower($name[0]);
                $methods[] = $name;
            }
        }
        return $methods;
    }

    private function getType(string $name): int
    {
        if ($name === 'id')
            return self::NUMBER_TYPE;
        if ($name === 'email')
            return self::EMAIL_TYPE;
        if ($name === 'password' || $name === 'passwordConfirm')
            return self::PASSWORD_TYPE;
        if ($name === 'birthday' || substr($name, -2) === 'At' || substr($name, -2) === 'at')
            return self::EMAIL_TYPE;

        return self::TEXT_TYPE;
    }

    public function add(string $name, int $type = 1, array $options = []): self
    {
        $this->form[$name] = ['type' => $type];
        $this->form[$name] = array_merge($this->form[$name], $options);
        return $this;
    }

    public function addClassToAll(array $options): self
    {
        $this->optionsToAll = $options;
        return $this;
    }

    public function getForm()
    {
        foreach ($this->getMethods() as $method) {
            $n = 0;
            foreach ($this->form as $input => $value) {
                if ($method === $input)
                    $n = 1;
            }
            if ($n === 0) {
                $notFound[] = $method;
            }
        }

        foreach ($notFound as $input) {
            $this->form[$input] = ['type' => $this->getType($input)];
        }

        foreach ($this->form as $input => $value) {
            if ($input !== '_formTheme') {
                if (isset($this->form[$input]['rowAttr']['class']) && isset($this->optionsToAll['rowAttr']['class']))
                    $this->form[$input]['rowAttr']['class'] = $this->optionsToAll['rowAttr']['class'] . ' ' . $this->form[$input]['rowAttr']['class'];
                if (isset($this->form[$input]['attr']['class']) && isset($this->optionsToAll['attr']['class']))
                    $this->form[$input]['attr']['class'] = $this->optionsToAll['attr']['class'] . ' ' . $this->form[$input]['attr']['class'];

                $this->form[$input] = array_merge($this->optionsToAll, $this->form[$input]);
            }
        }

        return $this->form;
    }

}