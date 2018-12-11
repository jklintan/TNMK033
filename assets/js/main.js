/** @param {string} type */
/** @param {string} jsondata */
/** @param {string} targetSelector */
const createGraph = (type, jsondata, targetSelector) => {
    const data = JSON.parse(jsondata)
    console.log(data)
    // if (data[0].number) {
    //     data.forEach(entry => {
    //         entry.number = parseInt(entry.number)
    //     })
    // }
    console.log(data)
    let graph
    if (type === 'numberSlider') {
        graph = createNumberSlider(data)
    }
    if (type === 'histogram') {
        graph = createHistogram(data)
    }
    if (graph) {
        const target = document.querySelector(targetSelector)
        if (target) {
            target.appendChild(graph)
        } else {
            console.log('No target html object found')
        }
    } else {
        console.log('No such graph existing')
    }
}

/** @param {Number} goTo */
/** @param {HTMLDivElement} element */
const numberSliderClick = (element, goTo) => {
    const slider = element.querySelector('div')
    const children = [].slice.call(element.children)
    if (children.length - 1 >= parseInt(slider.dataset.slider) + goTo && 0 <= parseInt(slider.dataset.slider) + goTo ) {
        const pos = parseInt(slider.dataset.slider) + goTo
        slider.style.transform = 'translateX(-' + pos * (100 / children.length) + '%)'
        slider.dataset.slider = pos
    }
}

/**
 * @param {dataobj[]} sliderData
 * @typedef {Object}  dataobj             - The data object
 * @property {Number}  dataobj.title       - The title
 * @property {String}  dataobj.text         - The text describing the data
 * @property {Number}  dataobj.number      - The number to diplay
 */
const createNumberSlider = (sliderData) => {
    const parent = document.createElement('div')
    const header = document.createElement('h2')
    const slider = document.createElement('div')
    const arrowRight = document.createElement('a')
    const arrowLeft = document.createElement('a')

    parent.classList.add('grapher', 'numberSlider')
    header.textContent = sliderData[0].title
    slider.style.width = sliderData.length * 100 + '%'
    slider.classList.add('slider')
    slider.dataset.slider = 0 // The data to show
    sliderData.forEach(object => {
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

findTallestData = (histogramData) => {
    if (histogramData[0].number) {
        let tallest = histogramData[0].number
        histogramData.forEach((data) => {
            tallest = data.number > tallest ? data.number : tallest
        })
        return tallest
    }
    console.log('Incorrect data type')
    return false
}

const createBar = (barData) => {
    const bar = document.createElement('div')
    bar.classList.add('bar')
}

/**
 * @param {dataobj[]} histogramData
 * @typedef {Object}  dataobj              - The data object
 * @property {Number}  dataobj.text    - The text describing the part
 * @property {Number}  dataobj.number    - The number to diplay
 */
const createHistogram = (histogramData) => {
    const scale = findTallestData(histogramData)
    // console.log(histogramData[0])
    console.log('Tallest is: ' + scale)
    const parent = document.createElement('div')
    histogramData.forEach = (entry) => {
        const bar = createBar(entry)
        parent.appendChild(bar)
    }
    return parent
}