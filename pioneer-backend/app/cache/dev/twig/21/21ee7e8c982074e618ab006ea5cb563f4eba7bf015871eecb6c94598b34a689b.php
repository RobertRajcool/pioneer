<?php

/* @Framework/Form/form_rows.html.php */
class __TwigTemplate_a55879319e64566925fa801b9b4f6946c7735aada452d3dbe7510c66d58eaf1e extends Twig_Template
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
        $__internal_5a9f6f70d001f1dd2f94c8ac427571eb04c18d820c9c78c40ea71a310de49506 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_5a9f6f70d001f1dd2f94c8ac427571eb04c18d820c9c78c40ea71a310de49506->enter($__internal_5a9f6f70d001f1dd2f94c8ac427571eb04c18d820c9c78c40ea71a310de49506_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/form_rows.html.php"));

        // line 1
        echo "<?php foreach (\$form as \$child) : ?>
    <?php echo \$view['form']->row(\$child) ?>
<?php endforeach; ?>
";
        
        $__internal_5a9f6f70d001f1dd2f94c8ac427571eb04c18d820c9c78c40ea71a310de49506->leave($__internal_5a9f6f70d001f1dd2f94c8ac427571eb04c18d820c9c78c40ea71a310de49506_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/form_rows.html.php";
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
        return new Twig_Source("<?php foreach (\$form as \$child) : ?>
    <?php echo \$view['form']->row(\$child) ?>
<?php endforeach; ?>
", "@Framework/Form/form_rows.html.php", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Form/form_rows.html.php");
    }
}
