<?php

/* FOSUserBundle:Group:show.html.twig */
class __TwigTemplate_5bc40acb87ae4d96cedd5180ebeebc9c03a23b193191f2b5543446ba4e1e04e5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("FOSUserBundle::layout.html.twig", "FOSUserBundle:Group:show.html.twig", 1);
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
        $__internal_031c98278880262916a0d07cac2abbd26b5a98f6a22233e3c71db8303c5c0568 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_031c98278880262916a0d07cac2abbd26b5a98f6a22233e3c71db8303c5c0568->enter($__internal_031c98278880262916a0d07cac2abbd26b5a98f6a22233e3c71db8303c5c0568_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Group:show.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_031c98278880262916a0d07cac2abbd26b5a98f6a22233e3c71db8303c5c0568->leave($__internal_031c98278880262916a0d07cac2abbd26b5a98f6a22233e3c71db8303c5c0568_prof);

    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_ddc74604ab321d681a0e4478975b73032a848fc758dce318bafe6c1772e3e4dc = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ddc74604ab321d681a0e4478975b73032a848fc758dce318bafe6c1772e3e4dc->enter($__internal_ddc74604ab321d681a0e4478975b73032a848fc758dce318bafe6c1772e3e4dc_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 4
        $this->loadTemplate("FOSUserBundle:Group:show_content.html.twig", "FOSUserBundle:Group:show.html.twig", 4)->display($context);
        
        $__internal_ddc74604ab321d681a0e4478975b73032a848fc758dce318bafe6c1772e3e4dc->leave($__internal_ddc74604ab321d681a0e4478975b73032a848fc758dce318bafe6c1772e3e4dc_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Group:show.html.twig";
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
{% include \"FOSUserBundle:Group:show_content.html.twig\" %}
{% endblock fos_user_content %}
", "FOSUserBundle:Group:show.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/friendsofsymfony/user-bundle/Resources/views/Group/show.html.twig");
    }
}
