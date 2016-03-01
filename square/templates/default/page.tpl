{% include 'default' %}
{% if page %}
<article>

  <h1 class="post-title">
    <a href="{{ site.url }}{{ page.url }}">{{ page.title }}</a>
  </h1>

  <div class=content>
    {{ page.content }}
  </div>

</article>
{% else %}
404
{% endif %}
{% include 'footer' %}
