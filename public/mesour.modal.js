/**
 * Mesour Modal Component - mesour.modal.js
 * @author Matous Nemec (http://mesour.com)
 */
var mesour = !mesour ? {} : mesour;
mesour.modal = !mesour.modal ? {} : mesour.modal;

(function ($) {

    var Modal = function (options) {

        var _this = this,
            modals = {};

        function getModal(modal) {
            if (typeof modal === 'string') {
                if (!modals[modal]) {
                    throw new Error('Modal "' + modal + '" not exist.');
                }
                return modals[modal];
            }
            return modal;
        };

        this.create = function ($modals) {
            $modals.each(function () {
                var $modal = $(this),
                    name = $modal.attr('data-mesour-modal');

                $modal.modal();
                modals[name] = $modal;
            });
        };

        this.getModal = function (modal) {
            return getModal(modal);
        };

        this.getBody = function (modal) {
            return getModal(modal).find('[mesour-modal-body]');
        };

        this.onHide = function (modal, callback) {
            modal = getModal(modal);
            modal.off('hide.bs.modal.mesour-editable');
            return getModal(modal).on('hide.bs.modal.mesour-editable', callback);
        };

        this.show = function (modal) {
            return getModal(modal).modal('show');
        };

        this.hide = function (modal) {
            return getModal(modal).modal('hide');
        };

        this.toggle = function (modal) {
            return getModal(modal).modal('toggle');
        };

        this.handleUpdate = function (modal) {
            return getModal(modal).modal('handleUpdate');
        };

        mesour.on.live('mesour-modal', function () {
            _this.create($('[data-mesour-modal]'));
        });
    };

    mesour.core.createWidget('modal', new Modal());
})(jQuery);