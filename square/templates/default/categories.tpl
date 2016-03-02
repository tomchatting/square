{% include 'default' %}
{% if category %}
  <h1>{{ page.title }}</h1>
  <hr>
  {% for post in category %}
  <article>

    <h2 class="post-title">
      <a href="{{ site.url }}articles/{{ post.url }}">{{ post.title }}</a>
    </h2>

    <time datetime="{{ post.date  }}" class="post-date">{{ post.date | date: "%d %B, %Y" }}</time>

    <hr>

  </article>
  {% endfor %}
{% endif %}

  <h1>Categories</h1>

  <ul>
  {% for cat in categories %}

  <li><a href="{{ site.url }}categories/{{ cat.name }}">{{ cat.name }}  </a></li>

  {% endfor %}
  </ul>


{% include 'footer' %}
