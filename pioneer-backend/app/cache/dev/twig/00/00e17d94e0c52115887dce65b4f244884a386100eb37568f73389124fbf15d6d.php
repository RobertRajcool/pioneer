<?php

/* WebProfilerBundle:Profiler:ajax_layout.html.twig */
class __TwigTemplate_349a0252b49760c44deeb3f19cdfd308aadbafe864216b4288105e4df02742c9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_a659899dc54780d5d30ccb28ec3ac0b9f8a13d686af5d4fe32c1b526b01c0fef = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_a659899dc54780d5d30ccb28ec3ac0b9f8a13d686af5d4fe32c1b526b01c0fef->enter($__internal_a659899dc54780d5d30ccb28ec3ac0b9f8a13d686af5d4fe32c1b526b01c0fef_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "WebProfilerBundle:Profiler:ajax_layout.html.twig"));

        // line 1
        $this->displayBlock('panel', $context, $blocks);
        
        $__internal_a659899dc54780d5d30ccb28ec3ac0b9f8a13d686af5d4fe32c1b526b01c0fef->leave($__internal_a659899dc54780d5d30ccb28ec3ac0b9f8a13d686af5d4fe32c1b526b01c0fef_prof);

    }

    public function block_panel($context, array $blocks = array())
    {
        $__internal_5a1b45ddd77a5eab3b0dcd0070928a11a8fde3f3a25d1f8935b49d350af3a59e = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_5a1b45ddd77a5eab3b0dcd0070928a11a8fde3f3a25d1f8935b49d350af3a59e->enter($__internal_5a1b45ddd77a5eab3b0dcd0070928a11a8fde3f3a25d1f8935b49d350af3a59e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        echo "";
        
        $__internal_5a1b45ddd77a5eab3b0dcd0070928a11a8fde3f3a25d1f8935b49d350af3a59e->leave($__internal_5a1b45ddd77a5eab3b0dcd0070928a11a8fde3f3a25d1f8935b49d350af3a59e_prof);

    }

    public function getTemplateName()
    {
        return "WebProfilerBundle:Profiler:ajax_layout.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  23 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% block panel '' %}
", "WebProfilerBundle:Profiler:ajax_layout.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/WebProfilerBundle/Resources/views/Profiler/ajax_layout.html.twig");
    }
}
