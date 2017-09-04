<?php

/* @Framework/Form/reset_widget.html.php */
class __TwigTemplate_3ff39d0afe5471433a592b9501b6791737d38e7fbc0eff73664d5298281e7467 extends Twig_Template
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
        $__internal_59e749cc0b975c5900d2f0bbc5f1c7a306876c6fc41f9d941b53aec3c556fd68 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_59e749cc0b975c5900d2f0bbc5f1c7a306876c6fc41f9d941b53aec3c556fd68->enter($__internal_59e749cc0b975c5900d2f0bbc5f1c7a306876c6fc41f9d941b53aec3c556fd68_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/reset_widget.html.php"));

        // line 1
        echo "<?php echo \$view['form']->block(\$form, 'button_widget', array('type' => isset(\$type) ? \$type : 'reset')) ?>
";
        
        $__internal_59e749cc0b975c5900d2f0bbc5f1c7a306876c6fc41f9d941b53aec3c556fd68->leave($__internal_59e749cc0b975c5900d2f0bbc5f1c7a306876c6fc41f9d941b53aec3c556fd68_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/reset_widget.html.php";
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
        return new Twig_Source("<?php echo \$view['form']->block(\$form, 'button_widget', array('type' => isset(\$type) ? \$type : 'reset')) ?>
", "@Framework/Form/reset_widget.html.php", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Form/reset_widget.html.php");
    }
}
