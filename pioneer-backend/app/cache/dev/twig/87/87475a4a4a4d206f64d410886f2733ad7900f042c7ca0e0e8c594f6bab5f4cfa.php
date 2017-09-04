<?php

/* FOSUserBundle:ChangePassword:change_password.html.twig */
class __TwigTemplate_e065ce4fcbf9a4d0431d50dd5c17aeb5b607836205bfae6a443c0630b4b79f7b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("FOSUserBundle::layout.html.twig", "FOSUserBundle:ChangePassword:change_password.html.twig", 1);
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
        $__internal_49eb93cb370574ae5fd1ff497a144a82139dbd892a040acdc142a4a2b2ac3bed = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_49eb93cb370574ae5fd1ff497a144a82139dbd892a040acdc142a4a2b2ac3bed->enter($__internal_49eb93cb370574ae5fd1ff497a144a82139dbd892a040acdc142a4a2b2ac3bed_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:ChangePassword:change_password.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_49eb93cb370574ae5fd1ff497a144a82139dbd892a040acdc142a4a2b2ac3bed->leave($__internal_49eb93cb370574ae5fd1ff497a144a82139dbd892a040acdc142a4a2b2ac3bed_prof);

    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_ec701c01372f936ff6de24fd192b9fa7c7bb88bd41d37337a943a72c4e83de17 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ec701c01372f936ff6de24fd192b9fa7c7bb88bd41d37337a943a72c4e83de17->enter($__internal_ec701c01372f936ff6de24fd192b9fa7c7bb88bd41d37337a943a72c4e83de17_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 4
        $this->loadTemplate("FOSUserBundle:ChangePassword:change_password_content.html.twig", "FOSUserBundle:ChangePassword:change_password.html.twig", 4)->display($context);
        
        $__internal_ec701c01372f936ff6de24fd192b9fa7c7bb88bd41d37337a943a72c4e83de17->leave($__internal_ec701c01372f936ff6de24fd192b9fa7c7bb88bd41d37337a943a72c4e83de17_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:ChangePassword:change_password.html.twig";
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
{% include \"FOSUserBundle:ChangePassword:change_password_content.html.twig\" %}
{% endblock fos_user_content %}
", "FOSUserBundle:ChangePassword:change_password.html.twig", "/var/www/html/pioneer/pioneer-backend/vendor/friendsofsymfony/user-bundle/Resources/views/ChangePassword/change_password.html.twig");
    }
}
