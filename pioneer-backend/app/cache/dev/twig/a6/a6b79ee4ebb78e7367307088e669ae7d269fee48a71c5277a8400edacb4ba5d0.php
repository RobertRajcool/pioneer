<?php

/* @Framework/Form/number_widget.html.php */
class __TwigTemplate_e5ece0e17ee9ecfb37c8d16c31cf46c9cf0d49101d413ad62a5e8ec63d2af50d extends Twig_Template
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
        $__internal_0f61c63651ab6bd355e4e274e111fa1b4064650779d1efc817bbc3f01f6c8220 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_0f61c63651ab6bd355e4e274e111fa1b4064650779d1efc817bbc3f01f6c8220->enter($__internal_0f61c63651ab6bd355e4e274e111fa1b4064650779d1efc817bbc3f01f6c8220_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/number_widget.html.php"));

        // line 1
        echo "<?php echo \$view['form']->block(\$form, 'form_widget_simple', array('type' => isset(\$type) ? \$type : 'text')) ?>
";
        
        $__internal_0f61c63651ab6bd355e4e274e111fa1b4064650779d1efc817bbc3f01f6c8220->leave($__internal_0f61c63651ab6bd355e4e274e111fa1b4064650779d1efc817bbc3f01f6c8220_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/number_widget.html.php";
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
        return new Twig_Source("<?php echo \$view['form']->block(\$form, 'form_widget_simple', array('type' => isset(\$type) ? \$type : 'text')) ?>
", "@Framework/Form/number_widget.html.php", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Form/number_widget.html.php");
    }
}
