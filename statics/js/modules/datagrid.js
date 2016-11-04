layui.define(function(exports){
    var obj = {
        ini : function(param) {
            var self = this;
            self.table = $(param.tableSelector);
            self.deleteUrl = param.deleteUrl;
            self.addDeleteEvent()
        }
        ,addDeleteEvent : function() {
            var self = this
            ,deleteBtn = self.table.find('#summer-btn-delete');

            deleteBtn.on('click', function(e){
                 var selectedRow = self.table.find('tr:has([name="summer-grid-row-index"]:checked)');
                 if(selectedRow.length === 0) {
                    layer.alert('请选择需要删除的项');
                 } else {
                    selectId = [];
                    selectTitles = [];
                    layui.each(selectedRow, function(index, item){
                         selectId.push($(item).find('[name="summer-grid-row-index"]').val());
                         selectTitles.push($(item).find('.summer-grid-row-title').text());
                    });

                    layer.confirm('确定是否需要删除【'+selectTitles.toString()+'】',
                        function(index){
                        layer.close(index); 
                        var loadIndex = layer.load();
                        $.post(self.deleteUrl, {delete_ids:selectId}, function(res){
                                layer.close(loadIndex);
                                if(!res || !res.msg) {
                                    layer.msg('删除失败');
                                } else {
                                    self.refreshGrid();
                                }
                            });
                        });
                 }
            });
        }
        ,refreshGrid : function() {
            location.reload();
        }
    }


    exports('datagrid', obj);
});
