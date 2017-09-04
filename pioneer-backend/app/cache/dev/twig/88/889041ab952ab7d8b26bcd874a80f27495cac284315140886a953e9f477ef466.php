<?php

/* @Framework/Form/email_widget.html.php */
class __TwigTemplate_a95cb01a01e4d229687ce6ed1672d39825892e34a3ccc0f84b9922699dfe4c64 extends Twig_Template
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
        $__internal_fb552c0a783975e476d685b2ae619eead82ccd6ad8a32c4a0fc74abd131dfe93 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_fb552c0a783975e476d685b2ae619eead82ccd6ad8a32c4a0fc74abd131dfe93->enter($__internal_fb552c0a783975e476d685b2ae619eead82ccd6ad8a32c4a0fc74abd131dfe93_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/email_widget.html.php"));

        // line 1
        echo "<?php echo \$view['form']->block(\$form, 'form_widget_simple', array('type' => isset(\$type) ? \$type : 'email')) ?>
";
        
        $__internal_fb552c0a783975e476d685b2ae619eead82ccd6ad8a32c4a0fc74abd131dfe93->leave($__internal_fb552c0a783975e476d685b2ae619eead82ccd6ad8a32c4a0fc74abd131dfe93_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/email_widget.html.php";
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
        return new Twig_Source("<?php echo \$view['form']->block(\$form, 'form_widget_simple', array('type' => isset(\$type) ? \$type : 'email')) ?>
", "@Framework/Form/email_widget.html.php", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Form/email_widget.html.php");
    }
}
