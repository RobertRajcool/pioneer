<?php

/* @Framework/Form/form_end.html.php */
class __TwigTemplate_365c0ecf4a972d7b2fd964b6a20cfe656c6cfd67f61e15ca19f1ebd2126512e9 extends Twig_Template
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
        $__internal_a674f7c3a0599f45a07a12ba6bad2100993e392b6057b515be7e1e88ddcc6ef5 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_a674f7c3a0599f45a07a12ba6bad2100993e392b6057b515be7e1e88ddcc6ef5->enter($__internal_a674f7c3a0599f45a07a12ba6bad2100993e392b6057b515be7e1e88ddcc6ef5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/form_end.html.php"));

        // line 1
        echo "<?php if (!isset(\$render_rest) || \$render_rest): ?>
<?php echo \$view['form']->rest(\$form) ?>
<?php endif ?>
</form>
";
        
        $__internal_a674f7c3a0599f45a07a12ba6bad2100993e392b6057b515be7e1e88ddcc6ef5->leave($__internal_a674f7c3a0599f45a07a12ba6bad2100993e392b6057b515be7e1e88ddcc6ef5_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/form_end.html.php";
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
        return new Twig_Source("<?php if (!isset(\$render_rest) || \$render_rest): ?>
<?php echo \$view['form']->rest(\$form) ?>
<?php endif ?>
</form>
", "@Framework/Form/form_end.html.php", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Form/form_end.html.php");
    }
}
