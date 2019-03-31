class window.PriceExpander
    base_class: '.price-list:visible'
    li_class: 'li'

    constructor: (n) ->
        @n = n

    _expand: (level = 1) ->
        selector = [@base_class]
        selector.push(@li_class) for i in [0..level-1]
        selector = selector.join(' ')
        expanded = false
        # debugger
        # todo: если максимально открытый список меньше N
        $(selector).each (i, e) =>
            return if expanded
            # if isMobile
            #     e = $(e).children('.price-section')
            # else
            e = $(e).children().children('.price-section')
            
            # если price-section тут имеются
            if e.length > 0
                console.log('clicking on ', e)
                console.log('selector', selector)
                console.log("Length: ", @getLength(), @isExpanded(), expanded)

                # кликаем только в случае, если свёрнуто
                # хотя она по умолчанию всегда должна быть свёрнута
                if not e.parent().children('ul').is(':visible')
                    e.click()
                    if @isExpanded()
                        # console.log("Length2: ", @getLength(), @isExpanded(), expanded)
                        # если после раскрытия элементов стало больше N,
                        # то кликаем еще раз, чтобы свернуть и стало <= N
                        # e.click()
                        expanded = true
                        return
        @_expand(level + 1) if not expanded && level < 5

    getLength: -> $([@base_class, @li_class].join(' ')).length

    isExpanded: -> @getLength() > @n

    @expand: (n) ->
        expander = new PriceExpander(n)
        expander._expand()
