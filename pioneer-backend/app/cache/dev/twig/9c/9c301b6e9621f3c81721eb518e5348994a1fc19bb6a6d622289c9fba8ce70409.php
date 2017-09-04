<?php

/* @Framework/Form/container_attributes.html.php */
class __TwigTemplate_4451b5745e8e662ba8fe1778b946218a7aa39e28b607335f265ca6429ce3d85f extends Twig_Template
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
        $__internal_7e7e0d789fa8f516f256384b511201a399c8519c249f6f6fb1314c8c4a76c616 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_7e7e0d789fa8f516f256384b511201a399c8519c249f6f6fb1314c8c4a76c616->enter($__internal_7e7e0d789fa8f516f256384b511201a399c8519c249f6f6fb1314c8c4a76c616_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/container_attributes.html.php"));

        // line 1
        echo "<?php echo \$view['form']->block(\$form, 'widget_container_attributes') ?>
";
        
        $__internal_7e7e0d789fa8f516f256384b511201a399c8519c249f6f6fb1314c8c4a76c616->leave($__internal_7e7e0d789fa8f516f256384b511201a399c8519c249f6f6fb1314c8c4a76c616_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/container_attributes.html.php";
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
        return new Twig_Source("<?php echo \$view['form']->block(\$form, 'widget_container_attributes') ?>
", "@Framework/Form/container_attributes.html.php", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Form/container_attributes.html.php");
    }
}
