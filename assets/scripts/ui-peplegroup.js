class modalFormPepleGroup extends HTMLElement {
  connectedCallback() {
    this.renderUiHTML();
  }
  renderUiHTML() {
    this.innerHTML = `
          <div class="modal fade bd-example-modal-xl" id="modalFormPepleGroup" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
          <div class="modal-content" id="">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มข้อมูลสมาชิก</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="myForm" method="post" action="backend/create_peplegroup.php" enctype="multipart/form-data">
              <div class="modal-body">
                <input type="hidden" name="status_form" value="create" />
                <input type="hidden" name="id_peplegroup" id="idpeplegroup" />
                <div class="mt-2 row border">
                  <div class="col-md-12">
                    <div class="form-group mb-2">
                      <label class="mt-0 mb-0 font-weight-bold text-dark">ชื่อสมาชิก</label>
                      <input type="text" class="form-control" name="peplegroup_names" id="peplegroupname" placeholder="ชื่อสมาชิก" required>
                    </div> 
                  </div>
                  <div class="col-md-7">
                    <div class="form-group mb-2">
                      <label class="mt-0 mb-0 font-weight-bold text-dark">เบอร์โทร</label>
                      <input type="text" class="form-control" name="phone_group" id="phoneGroup" placeholder="เบอร์โทร">
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group mb-2">
                      <label class="mt-0 mb-0 font-weight-bold text-dark">สถานะ</label>
                      <input type="text" class="form-control" name="status" id="status" placeholder="สถานะ" value="ลูกจ้าง">
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary ml-auto mr-4">บันทึกข้อมูล</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    `;
  }
}

customElements.define("main-form-peplegroup", modalFormPepleGroup);

$(document).on("click", "#openModalFormPepleGroup", function (e) {
  $("#idpeplegroup").val("");
  $("#peplegroupname").val("");
  $("#phoneGroup").val("");
  $("#status").val("ลูกจ้าง");
  e.preventDefault();
});

$(document).on("click", "#update_peplegroup", function (e) {
  let id = $(this).data("id");
  let name = $(this).data("name");
  let phone = $(this).data("phone");
  let status = $(this).data("status");

  $("#idpeplegroup").val(id);
  $("#peplegroupname").val(name);
  $("#phoneGroup").val(phone);
  $("#status").val(status);

  e.preventDefault();
});
