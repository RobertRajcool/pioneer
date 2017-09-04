<?php

/* @Framework/Form/password_widget.html.php */
class __TwigTemplate_4a25f14c841bda757e08ed6b186945abd53244439832cc724181260a3c3f70bf extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_838a655e5ae072fe1aaa12b4e324a324e5e2b28907f08712a64b5b4bddb15439 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_838a655e5ae072fe1aaa12b4e324a324e5e2b28907f08712a64b5b4bddb15439->enter($__internal_838a655e5ae072fe1aaa12b4e324a324e5e2b28907f08712a64b5b4bddb15439_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/password_widget.html.php"));

        // line 1
        echo "<?php echo \$view['form']->block(\$form, 'form_widget_simple', array('type' => isset(\$type) ? \$type : 'password')) ?>
";
        
        $__internal_838a655e5ae072fe1aaa12b4e324a324e5e2b28907f08712a64b5b4bddb15439->leave($__internal_838a655e5ae072fe1aaa12b4e324a324e5e2b28907f08712a64b5b4bddb15439_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/password_widget.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<?php echo \$view['form']->block(\$form, 'form_widget_simple', array('type' => isset(\$type) ? \$type : 'password')) ?>
", "@Framework/Form/password_widget.html.php", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Form/password_widget.html.php");
    }
}
