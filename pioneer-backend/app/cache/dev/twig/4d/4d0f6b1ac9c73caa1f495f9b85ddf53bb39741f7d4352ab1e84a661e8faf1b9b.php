<?php

/* TwigBundle:Exception:error.atom.twig */
class __TwigTemplate_1347d3328d143554163d6bcf5e7cbca5127357f1692666599262ce2aece42545 extends Twig_Template
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
        $__internal_6b5b699fc00bd41175c5fbcfe600d15f40349d69fe6e404c194f401ddd6a3068 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_6b5b699fc00bd41175c5fbcfe600d15f40349d69fe6e404c194f401ddd6a3068->enter($__internal_6b5b699fc00bd41175c5fbcfe600d15f40349d69fe6e404c194f401ddd6a3068_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:error.atom.twig"));

        // line 1
        $this->loadTemplate("@Twig/Exception/error.xml.twig", "TwigBundle:Exception:error.atom.twig", 1)->display($context);
        
        $__internal_6b5b699fc00bd41175c5fbcfe600d15f40349d69fe6e404c194f401ddd6a3068->leave($__internal_6b5b699fc00bd41175c5fbcfe600d15f40349d69fe6e404c194f401ddd6a3068_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:error.atom.twig";
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
        return new Twig_Source("{% include '@Twig/Exception/error.xml.twig' %}
", "TwigBundle:Exception:error.atom.twig", "/var/www/html/pioneer/pioneer-backend/vendor/symfony/symfony/src/Symfony/Bundle/TwigBundle/Resources/views/Exception/error.atom.twig");
    }
}
