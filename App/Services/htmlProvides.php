<?php

$html = array();

$html['js'] = [
  'applications' => ['applications.js'],
  'axios' => [ 'node_modules/axios/dist/axios.min.js' ],
  'blog_app' => ['blog_applications.js'],
  'prism' => ['plugins/prism/prism.js']
];

$html['css'] = [
  'applications' => ['applications.css'],
  'blog' => ['blog.css'],
  'prism' => ['plugins/prism/prism.css']
];

return $html;