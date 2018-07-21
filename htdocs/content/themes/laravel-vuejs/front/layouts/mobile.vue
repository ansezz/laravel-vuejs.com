<template>
  <div>

    <header>
      <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
          <a class="navbar-item" href="https://bulma.io">
            <h2 class="title is-4">The Media</h2>
          </a>
          <a class="navbar-item bd-navbar-item-documentation  is-active" href="/">
            Accueil
          </a>
          <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
          </a>
        </div>
      </nav>
    </header>
    <main>
      <nuxt/>
    </main>
    <footer class="footer">
      <div class="content has-text-centered">
        <p>
          <strong>Media Nuxt</strong> by <a href="https://github.com/ansezz">Anass Ez-Zouaine</a>. The source code is
          licensed
          <a href="http://opensource.org/licenses/mit-license.php">MIT</a>. The website content
          is licensed <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">CC BY NC SA 4.0</a>.
        </p>
      </div>
    </footer>
  </div>
</template>
