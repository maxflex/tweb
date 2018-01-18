class window.PriceExpander
    n: 5
    base_class: '.price-list'
    li_class: 'li:visible'

    _expand: (level = 1) ->
        selector = [@base_class]
        selector.push(@li_class) for i in [0..level-1]
        selector = selector.join(' ')
        expanded = false
        $(selector).each (i, e) =>
            e = $(e).find('>price-item>.price-section')
            e.click()
            if @isExpanded()
                # если после раскрытия элементов стало больше N,
                # то кликаем еще раз, чтобы свернуть и стало <= N
                # e.click()
                expanded = true
                return
        @_expand(level + 1) if not expanded

    getLength: -> $([@base_class, @li_class].join(' ')).length

    isExpanded: -> @getLength() > @n

    @expand: ->
        expander = new PriceExpander
        expander._expand()
