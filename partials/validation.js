const names = document.getElementById('name')
const telephone = document.getElementById('telephone')
const form = document.getElementById('form')
const reviews = document.getElementById('reviews')
const errorElement = document.getElementById('errors')


form.addEventListener('submit', (e) => {
  let messages = []
  
  if (names.value === ' ' || names.value == null) {
    messages.push('Name is required')
  }

  if (!(/^[a-zA-Z]/.test(names.value.trim()))) {
    messages.push('Name must contain alphabetical characters only')
  }

  if (!(/^[a-zA-Z]/.test(reviews.value.trim()))) {
    messages.push('Review must contain alphabetical characters only')
  }

  if (telephone.value.length < 9) {
    messages.push('telephone must be at least 9 characters')
  }

  if (telephone.value.length > 10) {
    messages.push('telephone is a maximum of 10 characters')
  }

  if (!(/^[0-9]+$/.test(telephone.value.trim()))) {
    messages.push('Mobile number must be digits')
  }

  if (messages.length > 0) {
    e.preventDefault()
    errorElement.innerText = messages.join(', ')
  }
})