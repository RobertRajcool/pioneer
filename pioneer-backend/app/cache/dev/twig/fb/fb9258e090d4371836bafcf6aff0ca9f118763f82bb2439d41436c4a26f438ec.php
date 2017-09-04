<?php

/* @Framework/Form/percent_widget.html.php */
class __TwigTemplate_d21389e3f5e70cc77915a952a72d264f0892c145e645ad3969a429bd5172f980 extends Twig_Template
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
        $__internal_050e7a5c0068c8f9b544ac7314dd67d062559b802254a24c740faa03ea88552f = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_050e7a5c0068c8f9b544ac7314dd67d062559b802254a24c740faa03ea88552f->enter($__internal_050e7a5c0068c8f9b544ac7314dd67d062559b802254a24c740faa03ea88552f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/percent_widget.html.php"));

        // line 1
        echo "<?php echo \$view['form']->block(\$form, 'form_widget_simple', array('type' => isset(\$type) ? \$type : 'text')) ?> %
";
        
        $__internal_050e7a5c0068c8f9b544ac7314dd67d062559b802254a24c740faa03ea88552f->leave($__internal_050e7a5c0068c8f9b544ac7314dd67d062559b802254a24c740faa03ea88552f_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/percent_widget.html.php";
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
        return new Twig_Source("<?php echo \$view['form']->block(\$form, 'form_widget_simple', array('type' => isset(\$type) ? \$type : 'text')) ?> %
", "@Framework/Form/percent_widget.html.php", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Form/percent_widget.html.php");
    }
}
