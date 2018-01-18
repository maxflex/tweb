class window.Expander
    n: 5
    base_class: '.price-list'
    li_class: 'li:visible'

    expand: (level = 1) ->
        selector = [@base_class]
        selector.push(@li_class) for i in [0..level]
        selector = selector.join(' ')
        # $(selector).each (e) ->
        #     console.log(e)

    getLength: ->
        $([@base_class, @li_class].join(' ')).length
