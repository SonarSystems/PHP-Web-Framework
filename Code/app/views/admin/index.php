<style>
      /* Ensure layout covers the entire screen. */
      html {
        height: 100%;
      }

      /* Place drawer and content side by side. */
      .demo-body {
        display: flex;
        flex-direction: row;
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        height: 100%;
        width: 100%;
      }

      /* Stack toolbar and main on top of each other. */
      .demo-content {
        display: inline-flex;
        flex-direction: column;
        flex-grow: 1;
        height: 100%;
        box-sizing: border-box;
      }

      .demo-main {
        padding-left: 16px;
      }
    </style>
<aside class="mdc-persistent-drawer mdc-persistent-drawer--open">
      <nav class="mdc-persistent-drawer__drawer">
        <div class="mdc-persistent-drawer__toolbar-spacer"></div>
        <div class="mdc-list-group">
          <nav class="mdc-list">
            <a class="mdc-list-item mdc-persistent-drawer--selected" href="#">
              <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">inbox</i>Inbox
            </a>
            <a class="mdc-list-item" href="#">
              <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">star</i>Star
            </a>
            <a class="mdc-list-item" href="#">
              <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">send</i>Sent Mail
            </a>
            <a class="mdc-list-item" href="#">
              <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">drafts</i>Drafts
            </a>
          </nav>

          <hr class="mdc-list-divider">

          <nav class="mdc-list">
              <a class="mdc-list-item" href="#">
                <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">email</i>All Mail
              </a>
              <a class="mdc-list-item" href="#">
                <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">delete</i>Trash
              </a>
              <a class="mdc-list-item" href="#">
                <i class="material-icons mdc-list-item__start-detail" aria-hidden="true">report</i>Spam
              </a>
            </nav>
          </div>
      </nav>
    </aside>

<div class="demo-content">
      <header class="mdc-toolbar mdc-elevation--z4">
        <div class="mdc-toolbar__row">
          <section class="mdc-toolbar__section mdc-toolbar__section--align-start">
            <button class="demo-menu material-icons mdc-toolbar__icon--menu">menu</button>
            <span class="mdc-toolbar__title catalog-title">Persistent Drawer</span>
          </section>
        </div>
      </header>

      <main class="demo-main">
        <h1 class="mdc-typography--display1">Persistent Drawer</h1>
        <p class="mdc-typography--body1">Click the menu icon above to open and close the drawer.</p>
      </main>

      <script>
        var drawerEl = document.querySelector('.mdc-persistent-drawer');
        var MDCPersistentDrawer = mdc.drawer.MDCPersistentDrawer;
        var drawer = new MDCPersistentDrawer(drawerEl);
        document.querySelector('.demo-menu').addEventListener('click', function() {
          drawer.open = !drawer.open;
        });
        drawerEl.addEventListener('MDCPersistentDrawer:open', function() {
          console.log('Received MDCPersistentDrawer:open');
        });
        drawerEl.addEventListener('MDCPersistentDrawer:close', function() {
          console.log('Received MDCPersistentDrawer:close');
        });
      </script>
    </div>