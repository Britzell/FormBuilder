<?php

define('ROOT', __DIR__ . '/');
require_once ROOT . 'vendor/autoload.php';

use Britzel\Form\FormBuilder;
use Britzel\Form\Tests\Entity\User;
use Britzel\Form\Form;

function d($v)
{
    echo '<pre>';
    var_dump($v);
    echo '</pre>';
}

$user = new User();

function createFormBuilder($entity, $theme = FormBuilder::DEFAULT_THEME) {
    return new FormBuilder($entity, $theme);
}
createFormBuilder($user, FormBuilder::BOOTSTRAP4_THEME)->isValid();
$formBuilder = createFormBuilder($user, FormBuilder::BOOTSTRAP4_THEME)
    ->addClassToAll(['attr' => ['class' => 'test']])
    ->add('email', FormBuilder::EMAIL_TYPE, ['label' => 'E-mail :', 'placeholder' => 'Email :', 'rowAttr' => ['class' => 'div'], 'attr' => ['class' => 'input'], 'required' => false])
    ->add('createdAt', FormBuilder::DATE_TYPE, ['disabled' => true]);

d($formBuilder->isSubmitted());
d($formBuilder->isValid());

$formView = $formBuilder->getForm();

d($formView);

$form = new Form();
?>
<form action="" method="post">
<?= $form->create($formView) ?>
</form>
