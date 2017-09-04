<?php

/* @Framework/Form/hidden_row.html.php */
class __TwigTemplate_e80a70c95e40235d0d570586b454c80f29b7d8c770b8e0a4f929ce6fa222c8f0 extends Twig_Template
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
        $__internal_f90cae7c40d89ccd7d9a45dfc0b3d6c3baf2a6646bf3e56f6cb856eb1e1bed8e = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_f90cae7c40d89ccd7d9a45dfc0b3d6c3baf2a6646bf3e56f6cb856eb1e1bed8e->enter($__internal_f90cae7c40d89ccd7d9a45dfc0b3d6c3baf2a6646bf3e56f6cb856eb1e1bed8e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/hidden_row.html.php"));

        // line 1
        echo "<?php echo \$view['form']->widget(\$form) ?>
";
        
        $__internal_f90cae7c40d89ccd7d9a45dfc0b3d6c3baf2a6646bf3e56f6cb856eb1e1bed8e->leave($__internal_f90cae7c40d89ccd7d9a45dfc0b3d6c3baf2a6646bf3e56f6cb856eb1e1bed8e_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/hidden_row.html.php";
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
        return new Twig_Source("<?php echo \$view['form']->widget(\$form) ?>
", "@Framework/Form/hidden_row.html.php", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Form/hidden_row.html.php");
    }
}
