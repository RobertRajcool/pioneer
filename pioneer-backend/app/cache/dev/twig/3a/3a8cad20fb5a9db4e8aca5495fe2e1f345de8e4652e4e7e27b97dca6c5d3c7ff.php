<?php

/* @Framework/Form/choice_options.html.php */
class __TwigTemplate_12e6eb751aa8ba2950ae99f3d60116fe4a5314103edecb35dcbf85e6b42d34d3 extends Twig_Template
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
        $__internal_0eb96f5dae8ea531ed90329d555728914059b5428bba9bf64901923ab56b0d8c = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_0eb96f5dae8ea531ed90329d555728914059b5428bba9bf64901923ab56b0d8c->enter($__internal_0eb96f5dae8ea531ed90329d555728914059b5428bba9bf64901923ab56b0d8c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/choice_options.html.php"));

        // line 1
        echo "<?php echo \$view['form']->block(\$form, 'choice_widget_options') ?>
";
        
        $__internal_0eb96f5dae8ea531ed90329d555728914059b5428bba9bf64901923ab56b0d8c->leave($__internal_0eb96f5dae8ea531ed90329d555728914059b5428bba9bf64901923ab56b0d8c_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/choice_options.html.php";
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
        return new Twig_Source("<?php echo \$view['form']->block(\$form, 'choice_widget_options') ?>
", "@Framework/Form/choice_options.html.php", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Form/choice_options.html.php");
    }
}
