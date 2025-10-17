class ModalForm extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: "open" });
  }

  connectedCallback() {
    this.render();
  }

  render() {
    //this.attachShadow({ mode: "open" });
    const sizemodel = this.getAttribute("size") || "";
    const title = this.getAttribute("title") || "";
    const modalId = this.getAttribute("ids") || "";
    console.log("is modal");
    this.shadowRoot.innerHTML = `
      <div class="modal fade bd-example-modal-xl" id="${modalId}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog ${sizemodel} modal-dialog-scrollable" role="document">
          <div class="modal-content" id="">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">${title}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
          </div>
        </div>
      </div>
    `;
  }
}

console.log("error");

export { ModalForm };
