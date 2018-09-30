
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

    <script>
        let minDate = new Date();
        minDate.setDate(minDate.getDate());
        $('#reservationtime').daterangepicker({
            minDate: minDate
        })
    </script>
</body>
</html>