<?php

/* FOSUserBundle:Registration:register.html.twig */
class __TwigTemplate_fd5a2be079ff009e73615c18d68f5d2715df2b742e6c82b25d847f77673df8fd extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("FOSUserBundle::layout.html.twig", "FOSUserBundle:Registration:register.html.twig", 1);
        $this->blocks = array(
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "FOSUserBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_359cbdeff1998197cc8124ebc52d4fb0cba014cb5cf6648b31a892c3e2347ec1 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_359cbdeff1998197cc8124ebc52d4fb0cba014cb5cf6648b31a892c3e2347ec1->enter($__internal_359cbdeff1998197cc8124ebc52d4fb0cba014cb5cf6648b31a892c3e2347ec1_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Registration:register.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_359cbdeff1998197cc8124ebc52d4fb0cba014cb5cf6648b31a892c3e2347ec1->leave($__internal_359cbdeff1998197cc8124ebc52d4fb0cba014cb5cf6648b31a892c3e2347ec1_prof);

    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_22ce811a7f6668a48da7e50dfc43525f1f688cf2a2e12ccd2797f2998b85b29b = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_22ce811a7f6668a48da7e50dfc43525f1f688cf2a2e12ccd2797f2998b85b29b->enter($__internal_22ce811a7f6668a48da7e50dfc43525f1f688cf2a2e12ccd2797f2998b85b29b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 4
        $this->loadTemplate("FOSUserBundle:Registration:register_content.html.twig", "FOSUserBundle:Registration:register.html.twig", 4)->display($context);
        
        $__internal_22ce811a7f6668a48da7e50dfc43525f1f688cf2a2e12ccd2797f2998b85b29b->leave($__internal_22ce811a7f6668a48da7e50dfc43525f1f688cf2a2e12ccd2797f2998b85b29b_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Registration:register.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 4,  34 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"FOSUserBundle::layout.html.twig\" %}

{% block fos_user_content %}
{% include \"FOSUserBundle:Registration:register_content.html.twig\" %}
{% endblock fos_user_content %}
", "FOSUserBundle:Registration:register.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/friendsofsymfony/user-bundle/Resources/views/Registration/register.html.twig");
    }
}
