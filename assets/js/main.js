// type = the type of graph (string)
// data = the graph data (JSON string array of objects)
// targetSelector = the target css selector (string)
const createGraph = (type, jsondata, targetSelector) => {
    const data = JSON.parse(jsondata)
    console.log(data)
    let graph
    if (type === 'numberSlider') {
        graph = createNumberSlider(data)
    }
    // if (type === 'histogram') {
    //     graph = createHistogram(data)
    // }
    if (graph) {
        const target = document.querySelector('body')
        target.appendChild(graph)
    }
}

const numberSliderClick = (element, goTo) => {
    const slider = element.querySelector('div')
    const children = [].slice.call(element.children)
    const pos = parseInt(slider.dataset.slider) + goTo
    console.log(pos)
    slider.style.transform = 'translateX(-' + pos * (100 / children.length) + '%)'
    slider.dataset.slider = pos
}

const createNumberSlider = (data) => {
    const parent = document.createElement('div')
    const header = document.createElement('h2')
    const slider = document.createElement('div')
    const arrowRight = document.createElement('a')
    const arrowLeft = document.createElement('a')

    parent.classList.add('grapher', 'numberSlider')
    header.textContent = data[0].title
    slider.style.width = data.length * 100 + '%'
    slider.classList.add('slider')
    slider.dataset.slider = 0 // The data to show
    data.forEach(object => {
        const entry = document.createElement('div')
        const p = document.createElement('p')
        p.textContent = object.data + ' ' + object.text
        entry.appendChild(p)
        slider.appendChild(entry)
    })

    arrowRight.classList.add('right')
    arrowRight.addEventListener('click', () => numberSliderClick(parent, 1))
    arrowRight.textContent = '▶'
    arrowLeft.classList.add('left')
    arrowLeft.addEventListener('click', () => numberSliderClick(parent, -1))
    arrowLeft.textContent = '◀'

    parent.appendChild(header)
    parent.appendChild(arrowLeft)
    parent.appendChild(arrowRight)
    parent.appendChild(slider)
    return parent
}