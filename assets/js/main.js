/** @param {string} type */
/** @param {string} jsondata */
/** @param {string} targetSelector */
const createGraph = (type, jsondata, targetSelector) => {
  // console.log(JSON.parse(jsondata))
  const graph = JSON.parse(jsondata)
  console.log(graph)
  if (graph.data[0].number) {
    graph.data.forEach(entry => {
          entry.number = parseInt(entry.number)
      })
  }
  let graphElement
  if (type === 'numberSlider') {
    graphElement = createNumberSlider(graph)
  }
  if (type === 'histogram') {
    graphElement = createHistogram(graph)
  }
  if (graphElement) {
    const target = document.querySelector(targetSelector)
    if (target) {
      target.appendChild(graphElement)
    } else {
      console.log('No target html object found')
    }
  } else {
    console.log('No such graph existing')
  }
}

const generateTestData = (amount) => {
  let testData = []
  for (let i = 0; i < amount; i++) {
    const element = { number: Math.random() * 10, text: 'datanamn' }
    testData.push(element)
  }
  return testData
}

const init = () => {
  createHistogram(generateTestData(100))
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

const findTallestData = (histogramData) => {
  if (histogramData.data[0].number) {
    let tallest = histogramData.data[0].number
    histogramData.data.forEach(data => {
      tallest = data.number > tallest ? data.number : tallest
    })
    return tallest
  }
  console.log('Incorrect data type')
  return false
}

/**
 * @param {dataobj[]} histogramData
 * @typedef {Object}  dataobj              - The data object
 * @property {Number}  dataobj.text    - The text describing the part
 * @property {Number}  dataobj.number    - The number to diplay
 */
const createBar = (barData, tallest) => {
  const bar = document.createElement('div')
  const info = document.createElement('div')
  const number = document.createElement('p')
  const text = document.createElement('p')
  const height = (barData.number / tallest) * 100
  bar.style.height = height + '%'
  // if (height > )
  bar.classList.add('bar')
  info.classList.add('barInfo')
  text.textContent = barData.text
  number.textContent = barData.number
  info.appendChild(text)
  info.appendChild(number)
  bar.appendChild(info)
  return bar
}

/**
 * @param {dataobj[]} histogramData
 * @typedef {Object}  dataobj              - The data object
 * @property {Number}  dataobj.text    - The text describing the part
 * @property {Number}  dataobj.number    - The number to diplay
 */
const createHistogram = (histogramData) => {
  const tallest = findTallestData(histogramData)
  // console.log(tallest)
  const parent = document.createElement('div')
  parent.classList.add('grapher', 'histogram')

  let delay = 0
  const step = 1000 / histogramData.length
  histogramData.data.forEach(entry => {
    const bar = createBar(entry, tallest)
    bar.style.animationDelay = delay + 'ms'
    delay += step
    parent.appendChild(bar)
  })
  document.querySelector('body').appendChild(parent)
  // return parent
}