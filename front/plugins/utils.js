import Vue from 'vue';

const getGqlValidationErrors = function (error) {
  if (!error.graphQLErrors)
    return null

  let validation = null;
  error.graphQLErrors.forEach((item) => {
    if (item.category === 'validation') {
      validation = item.extensions.validation
    }
  })

  return validation
}

Vue.prototype.$utils = {
  getGqlValidationErrors
}
