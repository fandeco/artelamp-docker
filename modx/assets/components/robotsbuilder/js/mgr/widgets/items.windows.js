RobotsBuilder.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'robotsbuilder-item-window-create';
    }
    Ext.applyIf(config, {
        title: _('robotsbuilder_item_create'),
        width: 550,
        autoHeight: true,
        url: RobotsBuilder.config.connector_url,
        action: 'mgr/item/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    RobotsBuilder.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(RobotsBuilder.window.CreateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'robotsbuilder-combo-type',
            fieldLabel: _('robotsbuilder_item_type'),
            name: 'type',
            id: config.id + '-type',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'modx-combo-context',
            fieldLabel: _('robotsbuilder_item_name'),
            name: 'context',
            id: config.id + '-context',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('robotsbuilder_item_description'),
            name: 'content',
            id: config.id + '-content',
            height: 150,
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('robotsbuilder_item_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('robotsbuilder-item-window-create', RobotsBuilder.window.CreateItem);


RobotsBuilder.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'robotsbuilder-item-window-update';
    }
    Ext.applyIf(config, {
        title: _('robotsbuilder_item_update'),
        width: 550,
        autoHeight: true,
        url: RobotsBuilder.config.connector_url,
        action: 'mgr/item/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    RobotsBuilder.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(RobotsBuilder.window.UpdateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'robotsbuilder-combo-type',
            fieldLabel: _('robotsbuilder_item_type'),
            name: 'type',
            id: config.id + '-type',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'modx-combo-context',
            fieldLabel: _('robotsbuilder_item_name'),
            name: 'context',
            id: config.id + '-context',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('robotsbuilder_item_description'),
            name: 'content',
            id: config.id + '-content',
            anchor: '99%',
            height: 150,
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('robotsbuilder_item_active'),
            name: 'active',
            id: config.id + '-active',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('robotsbuilder-item-window-update', RobotsBuilder.window.UpdateItem);

var storeitems = new Ext.data.ArrayStore({
    id: 'type-items'
    ,fields: ['value',{name: 'type', type: 'string'}]
    ,data: [['robots.txt','robots.txt'],['sitemap.xml','sitemap.xml']]
});
RobotsBuilder.combo.type = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: storeitems
        ,displayField: 'type'
        ,valueField: 'value'
        ,hiddenName: 'type'
        ,mode: 'local'
        ,triggerAction: 'all'
        ,editable: false
        ,selectOnFocus: false
        ,preventRender: true
        ,forceSelection: true
        ,enableKeyEvents: true
    });
    RobotsBuilder.combo.type.superclass.constructor.call(this,config);
};
Ext.extend(RobotsBuilder.combo.type,MODx.combo.ComboBox);
Ext.reg('robotsbuilder-combo-type',RobotsBuilder.combo.type);