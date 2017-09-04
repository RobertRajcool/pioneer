<?php

/* RankingBundle:Default:index.html.twig */
class __TwigTemplate_63a7dbbf3e6f984844ad262f037e6cdd8be57c47f5c25e18d571b18c6dd1e9ba extends Twig_Template
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
        $__internal_13a0effa47ec702dd808d99c30bece97b326f06558be76b768ad7145c0720056 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_13a0effa47ec702dd808d99c30bece97b326f06558be76b768ad7145c0720056->enter($__internal_13a0effa47ec702dd808d99c30bece97b326f06558be76b768ad7145c0720056_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "RankingBundle:Default:index.html.twig"));

        // line 1
        echo "Hello World!
";
        
        $__internal_13a0effa47ec702dd808d99c30bece97b326f06558be76b768ad7145c0720056->leave($__internal_13a0effa47ec702dd808d99c30bece97b326f06558be76b768ad7145c0720056_prof);

    }

    public function getTemplateName()
    {
        return "RankingBundle:Default:index.html.twig";
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
        return new Twig_Source("Hello World!
", "RankingBundle:Default:index.html.twig", "/var/www/html/pioneer/pioneer-backend/src/RankingBundle/Resources/views/Default/index.html.twig");
    }
}
