var _global_ = {
    favAdd : function(userId, operationId, obj) {
        $.getJSON(
            baseUrl + 'ajax/favAdd',
            {userId:userId, operationId:operationId, rand:Math.random()},
            function(json){
                if (json.status == 'success') {
                    obj.after('<a href="#" onclick="return _global_.favCancel(' + userId + ', ' + operationId + ',' + '$(this))">已收藏</span>');
                    obj.remove();
                } else {
                    alert(json.msg);
                }
            }
        );
        return false;
    },

    favCancel : function(userId, operationId, obj) {
        $.getJSON(
            baseUrl + 'ajax/favCancel',
            {userId:userId, operationId:operationId, rand:Math.random()},
            function(json){
                if (json.status == 'success') {
                    obj.after('<a href="#" onclick="return _global_.favAdd(' + userId + ', ' + operationId + ',' + '$(this))">收藏</span>');
                    obj.remove();
                } else {
                    alert(json.msg);
                }
            }
        );
        return false;
    }
}