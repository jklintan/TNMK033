/** @param {string} type */
/** @param {string} jsondata */
/** @param {string} targetSelector */
const createGraph = (type, jsondata, targetSelector) => {
  // console.log(JSON.parse(jsondata))
  const graph = JSON.parse(jsondata)
  // console.log(graph)
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
  if (type === 'pieChart') {
    graphElement = createPieChart(graph)
  }
  if (type === 'timeChart') {
    graphElement = createTimeChart(graph)
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
  const result = { data: testData }
  return result
}

const init = () => {
  document.querySelector('body').appendChild(createPieChart(generateTestData(4)))
  document.querySelector('body').appendChild(createTimeChart(generateTestData(2)))
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
  header.textContent = sliderData.title
  slider.style.width = sliderData.data.length * 100 + '%'
  slider.classList.add('slider')
  slider.dataset.slider = 0 // The data to show
  sliderData.data.forEach(object => {
    const entry = document.createElement('div')
    const p = document.createElement('p')
    p.textContent = object.number + ' ' + object.text
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
 * @param {dataobj[]} barData
 * @typedef {Object}  dataobj              - The data object
 * @property {Number}  dataobj.text    - The text describing the part
 * @property {Number}  dataobj.number    - The number to diplay
 */
const createBar = (barData, dataType, tallest) => {
  const bar = document.createElement('div')
  const info = document.createElement('div')
  const number = document.createElement('p')
  const text = document.createElement('p')
  const height = (barData.number / tallest) * 100

  let numberString
  if (dataType) {
    numberString = barData.number + ' ' + dataType
  } else {
    numberString = barData.number
  }
  if (height < 100 / 3) {
    bar.classList.add('top')
  }
  bar.style.height = height + '%'
  bar.classList.add('bar')
  info.classList.add('barInfo')
  text.textContent = barData.text
  number.textContent = numberString
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
  const parent = document.createElement('div')
  const scrollbox = document.createElement('div')
  const title = document.createElement('h2')
  title.textContent = histogramData.title
  parent.classList.add('grapher', 'histogram')
  parent.appendChild(title)

  let delay = 0
  const step = 1000 / histogramData.length
  const length = histogramData.data
  histogramData.data.forEach(entry => {
    const bar = createBar(entry, histogramData.dataType, tallest)
    bar.style.animationDelay = delay + 'ms'
    delay += step
    scrollbox.appendChild(bar)
  })
  const spacer = document.createElement('div')
  spacer.style.padding = '10px'
  scrollbox.appendChild(spacer)
  scrollbox.classList.add('slider')
  parent.appendChild(scrollbox)
  return parent
}

/**
 * @param {dataobj[]} pieChartData
 * @typedef {Object}  dataobj              - The data object
 * @property {Number}  dataobj.text    - The text describing the part
 * @property {Number}  dataobj.number    - The number to diplay
 */
const createPieChart = (pieChartData) => {
  const createPie = (data, color) => {
    const procent = data.number / total
    const slot = document.createElement('div')
    const intersect = document.createElement('div')
    slot.classList.add('slot')
    slot.style.transform = 'rotate(' + offset + 'deg)'
    offset += procent * 360
    intersect.classList.add('intersect')
    intersect.style.transform = 'rotate(' + (procent * 360) + 'deg)'
    intersect.style.backgroundColor = color
    if (procent > .5) {
      slot.style.overflow = 'visible'
      slot.style.backgroundColor = color
      slot.style.display = 'flex'
    }
    slot.appendChild(intersect)
    return slot
  }

  const createPieLabel = (data, color) => {
    const label = document.createElement('div')
    const dot = document.createElement('div')
    const p = document.createElement('p')
    const procentString = (Math.round(data.number / total * 1000) / 10) + '%'
    dot.style.backgroundColor = color
    p.textContent = procentString + ' ' + data.text
    label.appendChild(dot)
    label.appendChild(p)
    return label
  }

  const parent = document.createElement('div')
  const title = document.createElement('h2')
  const chart = document.createElement('div')
  const list = document.createElement('div')
  parent.classList.add('pieChart', 'grapher')
  title.textContent = pieChartData.title
  chart.classList.add('chart')
  list.classList.add('list')
  let total = 0
  pieChartData.data.forEach(data => {
    total += data.number
  })
  let offset = 0
  pieChartData.data.forEach(data => {
    const color = randomColor()
    chart.appendChild(createPie(data, color))
    list.appendChild(createPieLabel(data, color))
  })
  parent.appendChild(title)
  parent.appendChild(chart)
  parent.appendChild(list)
  return parent
}

const randomColor = () => {
  const sway = 200
  const seed = Math.floor(Math.random() * sway)
  const int = (input) => {
    return input + seed - sway / 2
  }
  const color = 'rgb(' + int(63) + ', ' + int(136) + ', ' + int(197) + ')'
  return color
}


/**
 * @param {dataobj[]} pieChartData
 * @typedef {Object}  dataobj              - The data object
 * @property {Number}  dataobj.text    - The text describing the part
 * @property {Number}  dataobj.number    - The number to diplay
 */

const createTimeChart = (timeData) => {
  let lastPos = {x: 0, y: 550}
  const createLine = (timeData, type, tallest, canvas, xpos) => {
    ctx.strokeStyle = '#fff'
    const ypos = timeData.number/tallest * canvas.height
    ctx.moveTo(lastPos.x, lastPos.y)
    ctx.lineTo(xpos, 550 - ypos)
    ctx.stroke()
    lastPos.x = xpos
    lastPos.y = 550 - ypos
  }
  const tallest = findTallestData(timeData)
  const parent = document.createElement('div')
  const canvas = document.createElement('canvas')
  const ctx = canvas.getContext("2d")
  ctx.moveTo(lastPos.x, lastPos.y)
  const title = document.createElement('h2')
  const length = timeData.data.length
  // window.innerWidth
  const step = (960 * 0.7 - 50) / length
  title.textContent = timeData.title
  parent.classList.add('grapher', 'timeChart')
  parent.appendChild(title)

  canvas.height = 550
  console.log(timeData)
  canvas.width = length * step
  canvas.style.width = length * step
  canvas.style.position = 'absolute'

  xpos = 0
  timeData.data.forEach(entry => {
    xpos += step
    createLine(entry, timeData.dataType, tallest, canvas, xpos)
  })
  const spacer = document.createElement('div')
  canvas.appendChild(spacer)
  canvas.classList.add('slider')
  parent.appendChild(canvas)
  return parent
}

