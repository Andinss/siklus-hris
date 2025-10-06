

<script>

Vue.use(Vuetable)
var vm = new Vue({

  el: '#subApp',
  data: {
    loading: '',
    searchFor: '',
    filterDate: '',
    columns: [
      {
        name: 'id',
        title: '#',
        sortField: 'id'
      },
      {
        name: 'no_transaction',
        title: 'No. Transaction',
        sortField: 'no_trans'
      },
      {
        name: 'date_transaction',
        title: 'Date',
        sortField: 'date_trans'
      },

      {
        name: 'customer',
        title: 'Customer Name',
        sortField: 'customer_name'
      },

      {
        name: 'type',
        title: 'Customer Type',
        sortField: 'delivery_order_type_name'

      },
      {
        name: 'branch',
        title: 'Branch',
        sortField: 'branch_name'

      },
      {
        name: 'warehouse',
        title: 'Warehouse',
        sortField: 'warehouse_name'  

      },
      {
        name: '__slot:actions',
        title: 'Action'
      },
    ],
    moreParams: {},
    sortOrder: [{
      field: 'id',
      direction: 'desc'
    }],
    css: {
      table: {
        tableClass: 'table table-striped',
        ascendingIcon: 'fa fa-angle-up',
        descendingIcon: 'fa fa-angle-down',
      },
      pagination: {
        wrapperClass: "btn-group",
        activeClass: "active",
        disabledClass: "disabled",
        pageClass: "btn btn-default",
        linkClass: "btn btn-default",
        icons: {
          first: "ti-angle-double-left",
          prev: "ti-angle-left",
          next: "ti-angle-right",
          last: "ti-angle-double-right"
        }
      }
    },

    perPage:5,
    paginationInfoTemplate: '<strong>Showing record</strong> {from} to {to} from {total} item(s)',
  },

  mounted: function() {
    var self = this;
    $('input[name="daterange"]').daterangepicker({
      opens: 'left'
    }, function(start, end, label) {
      let date = start.format('YYYY-MM-DD')+'|'+end.format('YYYY-MM-DD')
      self.filterDate = date
    })
  },

  methods:{
    printTable(){
      axios("{{ URL::route('editor.popup.data') }}")
      .then(function(response){
        let data = response.data.data
        var div = document.createElement('div')
        var table = document.createElement("table");
        table.style.borderCollapse = 'collapse'
        var thead = document.createElement("thead");
        var tbody = document.createElement("tbody");
        var headRow = document.createElement("tr");
        ['ID', 'No.Transaction', 'Date', 'Customer', 'Type', 'Warehouse'].forEach(function(el) {
          var th = document.createElement("th");
          th.appendChild(document.createTextNode(el));
          headRow.appendChild(th);
        });
        thead.appendChild(headRow);
        table.appendChild(thead);
        data.forEach(function(el) {
          var tr = document.createElement("tr");
          for (var o in el) {
            var td = document.createElement("td");
            td.appendChild(document.createTextNode(el[o]))
            tr.appendChild(td);
          }
          tbody.appendChild(tr);
        });
        table.appendChild(tbody);
        div.appendChild(table);

        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">' + div.outerHTML + '</body></html>');
        newWin.document.close();

        // let documentGet = table
        // let originalDocument = document.body.innerHTML
        // document.body.innerHTML = documentGet
        // window.print()
        // document.body.innerHTML = originalDocument
        this.close()

      })
      .catch(function(error){
        alert(error)
      })


    },
    close(){
      $(".popup").hide()
    },
    editRow(rowData){
      location.href = "{{url('editor/delivery-order-process')}}" + `/edit/${rowData.id}`
    },

    setFilter(filterText){
      this.moreParams = {
        'filter' : this.searchFor,

      }
      this.$nextTick(function(){
        this.$refs.vuetable.refresh()
      })
    },

    setDate(val){

      this.moreParams = {
        'filter': this.filterDate
      }

      this.$nextTick(function(){
        this.$refs.vuetable.refresh()
      })
    },

    resetFilter(){
      moreParams = {}
      this.searchFor = ''
      this.from = ''
      this.to = ''
      this.setFilter()
    },

    refreshTable(){
      this.$refs.vuetable.refresh()
    },

    showLoader(){
      this.loading = 'loading'
    },

    hideLoader (){
      this.loading = ''
    },

    onPaginationData (tablePagination) {
      this.$refs.paginationInfo.setPaginationData(tablePagination)
      this.$refs.pagination.setPaginationData(tablePagination)
    },
    onChangePage (page) {
      this.$refs.vuetable.changePage(page)
    },
    onInitialized (fields) {
      this.vuetableFields = fields
    },

    onCellClicked (data, field, event) {
      this.$refs.vuetable.toggleDetailRow(data.id)
    },

    onFormatDate(value, formated){
      if(value == null) return ''
      formated = (typeof formated === undefined) ? 'D MMM YYYY' : formated
      return moment(value, 'YYYY-MM-DD').format(formated)
    },

    onDataReset () {
      this.$refs.paginationInfo.resetData()
      this.$refs.pagination.resetData()
    },


  }

})

</script>
