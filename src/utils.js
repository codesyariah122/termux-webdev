export const random = ()=>{
  return Math.random().toString().substr(2,12)
}

export const time = () => {
  const d = new Date()
  const date = d.getDate() <= 9 ? `0${d.getDate()}` : d.getDate()
  const month = d.getDate() <= 9 ? `0${d.getDate()}` : d.getDate()
  const watch = `${d.getHours()}:${d.getMinutes()}:${d.getSeconds()}`
  return `${date}-${month}-${d.getFullYear()}, ${watch}`
}