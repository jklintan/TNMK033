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
    const target = document.querySelector('body')
    target.appendChild(graph)
}

const createNumberSlider = (data) => {
    const parent = document.createElement('div')
    const header = document.createElement('h2')
    const slider = document.createElement('div')
    parent.classList.add('grapher', 'numberSlider')
    header.textContent = data[0].title
    data.forEach(object => {
        const entry = document.createElement('div')
        const p = document.createElement('p')
        p.textContent = object.data + ' ' + object.text
        entry.appendChild(p)
        slider.appendChild(entry)
    })
    parent.appendChild(header)
    parent.appendChild(slider)
    return parent
}