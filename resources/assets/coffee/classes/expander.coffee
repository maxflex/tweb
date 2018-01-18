class window.PriceExpander
    n: 30
    base_class: '.price-list'
    li_class: 'li:visible'

    _expand: (level = 1) ->
        selector = [@base_class]
        selector.push(@li_class) for i in [0..level-1]
        selector = selector.join(' ')
        expanded = false
        $(selector).each (i, e) =>
            return if expanded
            # console.log("Length: ", @getLength(), @isExpanded(), expanded)
            e = $(e).find('>price-item>.price-section')
            e.click()
            if @isExpanded()
                # console.log("Length2: ", @getLength(), @isExpanded(), expanded)
                # если после раскрытия элементов стало больше N,
                # то кликаем еще раз, чтобы свернуть и стало <= N
                e.click()
                expanded = true
                return
        @_expand(level + 1) if not expanded

    getLength: -> $([@base_class, @li_class].join(' ')).length

    isExpanded: -> @getLength() > @n

    @expand: ->
        expander = new PriceExpander
        expander._expand()
