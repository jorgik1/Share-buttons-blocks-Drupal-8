# Share-buttons-blocks-Drupal-8
Very flexible sharing buttons blocks with layout on each button.

Form settings ![Form settings](http://joxi.net/1A5Z49gHKKEdEr.jpg "form settings") 
On the page ![Page](http://joxi.net/J2b475nU44EZXr.jpg "On the page")

# Process of creating each button very similar with creation of panel template.

* In Drupal 8 for configuration of templates we are using yml-files. It's key-value format files. We have keys elements from left side and value elements from right. Simple example : 

      email:
        label: Email button template
        category: 'Buttons layouts'
        path: templates/buttons_layout/email
        css: email.css
        icon: email.png
        template: email
        regions:
          main:
            label: Main
            

* So, in small example I showed of 1 button template creation, this is file name : _share_button_blocks.layouts.yml_

In this file you can add a lot of buttons as you needed. this files in our project looks like this :

    
    email:
      label: Email button template
      category: 'Buttons layouts'
      path: templates/buttons_layout/email
      css: email.css
      icon: email.png
      template: email
      regions:
        main:
          label: Main
    facebook:
      label: Facebook button template
      category: 'Buttons layouts'
      path: templates/buttons_layout/facebook
      css: facebook.css
      icon: facebook.png
      template: facebook
      regions:
        main:
          label: Main
    linkedin:
      label: linkedin button template
      category: 'Buttons layouts'
      path: templates/buttons_layout/linkedin
      css: linkedin.css
      icon: linkedin.png
      template: linkedin
      regions:
        main:
          label: Main
    twitter:
      label: twitter button template
      category: 'Buttons layouts'
      path: templates/buttons_layout/twitter
      css: twitter.css
      icon: twitter.png
      template: twitter
      regions:
        main:
          label: Main
    googleplus:
      label: googleplus button template
      category: 'Buttons layouts'
      path: templates/buttons_layout/googleplus
      css: googleplus.css
      icon: googleplus.png
      template: googleplus
      regions:
        main:
          label: Main
    pinterest:
      label: pinterest button template
      category: 'Buttons layouts'
      path: templates/buttons_layout/pinterest
      css: pinterest.css
      icon: pinterest.png
      template: pinterest
      regions:
        main:
          label: Main
    tumblr:
      label: tumblr button template
      category: 'Buttons layouts'
      path: templates/buttons_layout/tumblr
      css: tumblr.css
      icon: tumblr.png
      template: tumblr
      regions:
        main:
          label: Main
    reddit:
      label: reddit button template
      category: 'Buttons layouts'
      path: templates/buttons_layout/reddit
      css: reddit.css
      icon: reddit.png
      template: reddit
      regions:
        main:
          label: Main
    print:
      label: print button template
      category: 'Buttons layouts'
      path: templates/buttons_layout/print
      css: print.css
      icon: print.png
      template: print
      regions:
        main:
          label: Main
    test:
      label: test button template
      category: 'Buttons layouts'
      path: templates/buttons_layout/test
      css: test.css
      icon: test.png
      template: test
      regions:
        main:
          label: Main
          
          

* Next step is creating of link template with desirable markup. Small example :
        
        {% set li_class = [
        'big-social-media__item',
        'big-social-media__item--' ~ settings.link_class|clean_class
        ] %}
        <li{{ attributes.setAttribute('class', li_class) }}>
            <a class="big-social-media__btn popup"{% if settings.link_id %} id="{{  settings.link_id }}" {% endif %} {% if settings.links_rel %} rel="{{ settings.links_rel }}" {% endif %}
               href="https://www.facebook.com/dialog/feed?app_id={{ settings.facebook_id }}&amp;description={{ settings.link.description }}&amp;display=popup&amp;caption={{ settings.link.title }}&amp;link={{ settings.link.url }}&amp;redirect_uri=http://www.facebook.com">
                 <span class="big-social-media__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="29" height="29" viewBox="0 0 29 29">
                        <title>{{ settings.link_class }} icon</title>
                        <path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/>
                    </svg>
                 </span>
                <span class="big-social-media__label">{{ settings.link_class }}</span>   </a>
        </li>

this file contain a html markup for 1 button with link elements and variables. File is saved in
<code>/modules/custom/share_button_blocks/templates/buttons_layout/facebook/facebook.html.twig</code>

So if you need to create new button, you should create directory with file, and name it as your button. Example:

<code>/modules/custom/share_button_blocks/templates/buttons_layout/TEST_BUTTON/TEST_BUTTON.html.twig</code>
