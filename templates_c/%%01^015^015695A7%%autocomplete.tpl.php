<?php ob_start(); ?>

    data-minimum-input-length="<?php echo $this->_tpl_vars['Editor']->getMinimumInputLength(); ?>
"
    data-url="<?php echo $this->_tpl_vars['Editor']->getDataUrl(); ?>
"

<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('AdditionalProperties', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editors/text.tpl", 'smarty_include_vars' => array('AdditionalProperties' => $this->_tpl_vars['AdditionalProperties'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>