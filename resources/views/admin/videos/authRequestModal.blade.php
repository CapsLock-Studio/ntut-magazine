@if (empty(Session::get('token')))
  <div class="modal" id="request-oauth-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">授權請求</h4>
        </div>
        <div class="modal-body">
          <p>系統需要擁有 YouTube 授權才能管理影片項目，需要您協助授權。</p>
        </div>
        <div class="modal-footer">
          <a href="/auth/google" class="btn btn-primary">前往授權</a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <script>
    $(document).ready(function() {
      $('#request-oauth-modal').modal('show');
    });
  </script>
@endif