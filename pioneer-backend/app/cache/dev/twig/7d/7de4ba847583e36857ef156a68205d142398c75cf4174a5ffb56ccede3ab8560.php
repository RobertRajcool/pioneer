<?php

/* @Framework/Form/form_enctype.html.php */
class __TwigTemplate_3e52efb8b4233f994f10a921f2b0d742a03599a71c802a01be39a07ba5f7c99c extends Twig_Template
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
        $__internal_cbb117d855b4a4af73def5f23cb8840092aefeaf5e4eff514a044acbea5cfbd1 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_cbb117d855b4a4af73def5f23cb8840092aefeaf5e4eff514a044acbea5cfbd1->enter($__internal_cbb117d855b4a4af73def5f23cb8840092aefeaf5e4eff514a044acbea5cfbd1_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/form_enctype.html.php"));

        // line 1
        echo "<?php if (\$form->vars['multipart']): ?>enctype=\"multipart/form-data\"<?php endif ?>
";
        
        $__internal_cbb117d855b4a4af73def5f23cb8840092aefeaf5e4eff514a044acbea5cfbd1->leave($__internal_cbb117d855b4a4af73def5f23cb8840092aefeaf5e4eff514a044acbea5cfbd1_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/form_enctype.html.php";
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
        return new Twig_Source("<?php if (\$form->vars['multipart']): ?>enctype=\"multipart/form-data\"<?php endif ?>
", "@Framework/Form/form_enctype.html.php", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Form/form_enctype.html.php");
    }
}
