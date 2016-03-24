<!doctype html>
<html lang=en>
<meta charset=utf-8>
<title>{{ site.title }} {{ page.title }}</title>
<link rel=stylesheet href={{ site.url }}square/templates/default/style.css>
<div class="container content">

<header class="masthead">
  <h3 class="masthead-title">
    <a href="{{ site.url }}">{{ site.title }}</a>
    <small>{{ site.headline }} | <a href={{ site.url }}categories>Categories</a>{% for li in nav %} | <a href="{{ site.url }}{{ li.url }}">{{ li.title }}</a>{% endfor %}</small>
  </h3>
</header>
