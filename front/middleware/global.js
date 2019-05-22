export default function (context) {

  if (context.store.state.auth.loggedIn)
    return context.store.dispatch("auth/LOAD_ME")

  /*if (context.query.token)
    return context.store.dispatch("auth/SET_TOKEN", context.query.token)*/
}
