L.Control.SlideMenu = L.Control.extend({
    options: {
        position: 'topleft',
        menuposition: 'topleft', // topleft,topright,bottomleft,bottomright
        width: '300px',
        height: '100%',
        direction: 'horizontal', // vertical or horizontal
        changeperc: '10',
        delay: '10',
        icon: 'fa-solid fa-bars',
        hidden: false,
        icon_close: {
            class_up: 'fa-solid fa-chevron-up',
            class_down: 'fa-solid fa-chevron-down',
            class_left: 'fa-solid fa-chevron-left',
            class_right: 'fa-solid fa-chevron-right',
            size: '16pt',
            color: '#BBCC22'
        }
    },

    initialize: function (innerHTML, options) {
        L.Util.setOptions(this, options);
        this._innerHTML = innerHTML;
        this._isLeftPosition = this.options.menuposition == 'topleft' ||
            this.options.menuposition == 'bottomleft' ? true : false;
        this._isTopPosition = this.options.menuposition == 'topleft' ||
            this.options.menuposition == 'topright' ? true : false;
        this._isHorizontal = this.options.direction == 'horizontal' ? true : false;
    },


    onAdd: function (map) {
        this._container = L.DomUtil.create('div', 'leaflet-control-slidemenu leaflet-bar leaflet-control');
        var link = L.DomUtil.create('a', 'leaflet-bar-part leaflet-bar-part-single', this._container);
        link.title = 'Menu';
        L.DomUtil.create('span', this.options.icon, link);

        this._menu = L.DomUtil.create('div', 'leaflet-menu', map._container);


        this._menu.style.width = this.options.width;
        this._menu.style.height = this.options.height;

        if (this._isHorizontal) {
            var frominit = -(parseInt(this.options.width, 10));
            if (this._isLeftPosition) {
                this._menu.style.left = '-' + this.options.width;
            }
            else {
                this._menu.style.right = '-' + this.options.width;
            }

            if (this._isTopPosition) {
                this._menu.style.top = '0px';
            }
            else {
                this._menu.style.bottom = '0px';
            }
        }
        else {
            var frominit = -(parseInt(this.options.height, 10));
            if (this._isLeftPosition) {
                this._menu.style.left = '0px';
            }
            else {
                this._menu.style.right = '0px';
            }

            if (this._isTopPosition) {
                this._menu.style.top = '-' + this.options.height;
            }
            else {
                this._menu.style.bottom = '-' + this.options.height;
            }
        }


        var closeButton = L.DomUtil.create('button', 'leaflet-menu-close-button', this._menu);

        closeButton.style.fontSize = this.options.icon_close.size;
        closeButton.style.color = this.options.icon_close.color;


        if (this._isHorizontal) {
            if (this._isLeftPosition) {
                closeButton.style.float = 'right';
                L.DomUtil.addClass(closeButton, this.options.icon_close.class_left);
            }
            else {
                closeButton.style.float = 'left';
                L.DomUtil.addClass(closeButton, this.options.icon_close.class_right);
            }
        }
        else {
            if (this._isTopPosition) {
                closeButton.style.float = 'right';
                L.DomUtil.addClass(closeButton, this.options.icon_close.class_up);
            }
            else {
                closeButton.style.float = 'right';
                L.DomUtil.addClass(closeButton, this.options.icon_close.class_down);
            }
        }

        this._contents = L.DomUtil.create('div', 'leaflet-menu-contents', this._menu);
        this._contents.innerHTML = this._innerHTML;
        this._contents.style.clear = 'both';

        if (this._isHorizontal) {
            var ispx = this.options.width.slice(-1) == 'x' ? true : false;
            var unit = parseInt(this.options.width, 10) * parseInt(this.options.changeperc, 10) / 100;
        }
        else {
            var ispx = this.options.height.slice(-1) == 'x' ? true : false;
            var unit = parseInt(this.options.height, 10) * parseInt(this.options.changeperc, 10) / 100;
        }

        L.DomEvent.disableClickPropagation(this._menu);
        L.DomEvent

        .on(link, 'click', L.DomEvent.stopPropagation)
        .on(link, 'click', function () {
            // Open
            this._animate(this._menu, frominit, 0, true, ispx, unit);
        }, this)
        .on(closeButton, 'click', L.DomEvent.stopPropagation)
        .on(closeButton, 'click', function () {

                this._animate(this._menu, 0, frominit, false, ispx, unit);
            }, this);
        L.DomEvent.on(this._menu, 'mouseover', function () {
            map.scrollWheelZoom.disable();
        });
        L.DomEvent.on(this._menu, 'mouseout', function () {
            map.scrollWheelZoom.enable();
        });

        if (this.options.hidden) {
            this.hide();
        }

        var regionLabel = L.DomUtil.create('label', 'leaflet-menu-filter-label', this._contents);
        regionLabel.innerHTML = 'Région';
        regionLabel.setAttribute('for', 'region-filter');

        var regionSelect = L.DomUtil.create('select', 'leaflet-menu-filter', this._contents);
        regionSelect.id = 'region-filter';
        // Ajouter les options du menu déroulant pour la région
        var regionOptions = [
            { value: 'region1', label: 'Auvergne-Rhône-Alpes' },
            { value: 'region2', label: 'Bourgogne-Franche-Comté' },
            { value: 'region3', label: 'Bretagne' },
            { value: 'region4', label: 'Centre Val de Loir' },
            { value: 'region5', label: 'Centre Val de Loire' },
            { value: 'region6', label: 'Corse' },
            { value: 'region7', label: 'Grand Est' },
            { value: 'region8', label: 'Hauts-de-France' },
            { value: 'region9', label: 'Île-de-France' },
            { value: 'region10', label: 'Normandie' },
            { value: 'region11', label: 'Nouvelle Aquitaine' },
            { value: 'region12', label: 'Pays de la Loire' },

            // Ajoutez d'autres régions si nécessaire

        ];
        regionOptions.forEach(function (option) {
            var regionOption = L.DomUtil.create('option', '', regionSelect);
            regionOption.value = option.value;
            regionOption.text = option.label;
        });
        // Ajouter les filtres à coche
        var activityFilter = L.DomUtil.create('div', 'leaflet-menu-filter', this._contents);

        var activityLabel = L.DomUtil.create('label', 'leaflet-menu-filter-label', activityFilter);
        activityLabel.innerHTML = 'Secteur-activité';



        var sectorActivity = L.DomUtil.create('select', 'leaflet-menu-filter-select', activityFilter);
        sectorActivity.id = 'secteur-activity-filter';
        sectorActivity.innerHTML = '<option value=""> Agriculture, sylviculture et pêche</option>' +
            '<option value="activity1">Industries extractives</option>' +
            '<option value="activity2">Industrie manufacturière</option>' +
            '<option value="activity3">Production et distribution d\'électricité, de gaz, de vapeur et d\'air conditionné</option>'+
        '<option value="activity3"> Production et distribution d\'eau; assainissement, gestion des déchets et dépollution</option>'+
        '<option value="activity3">Commerce ; réparation d\'automobiles et de motocycles</option>'+
        '<option value="activity3">Transports et entreposage</option>'+
        '<option value="activity3">Hébergement et restauration</option>'+
        '<option value="activity3">Information et communication</option>'+
        '<option value="activity3">Activités financières et d\'assurance</option>'+
        '<option value="activity3">Activités immobilières</option>'+
        '<option value="activity3">Activités spécialisées, scientifiques et techniques</option>'+
        '<option value="activity3">Activités de services administratifs et de soutien</option>'+
        '<option value="activity3">Administration publique</option>'+
        '<option value="activity3">Enseignement</option>'+
        '<option value="activity3">Santé humaine et action sociale</option>'+
        '<option value="activity3">Arts,spectacles et activités récréatives</option>'+
        '<option value="activity3">Arts,spectacles et activités récréatives</option>'+
        '<option value="activity3">Arts,spectacles et activités récréatives</option>'+
        '<option value="activity3">Autres activités de services</option>'+
        '<option value="activity3">Activités des ménages en tant qu\'employeurs ; activités indifférenciées des ménages en tant que producteurs de biens et services pour usage propre</option>'+
        '<option value="activity3">Activités extra-territoriales</option>';


        var activityFilter = L.DomUtil.create('div', 'leaflet-menu-filter', this._contents);
        
        var activityLabel = L.DomUtil.create('label', 'leaflet-menu-filter-label', activityFilter);
        activityLabel.innerHTML = 'Activité';

        var activitySelect = L.DomUtil.create('select', 'leaflet-menu-filter-select', activityFilter);
        activitySelect.id = 'activity-filter';
        activitySelect.innerHTML = '<option value="">Restauration</option>'+
            '<option value="activity1">Snack</option>'+
            '<option value="activity2">Traiteur</option>'+
            '<option value="activity3">Collectivité</option>'+
            '<option value="activity4">Collectivité</option>'+
            '<option value="activity5">Collectivité</option>'+
            '<option value="activity6">Collectivité</option>'+
            '<option value="activity7">Collectivité</option>'+
            '<option value="activity8">Collectivité</option>'+
            '<option value="activity9">Collectivité</option>';


        return this._container;
    },

    onRemove: function (map) {
        //Remove sliding menu from DOM
        map._container.removeChild(this._menu);
        delete this._menu;
    },

    setContents: function (innerHTML) {
        this._innerHTML = innerHTML;
        this._contents.innerHTML = this._innerHTML;
    },

    _animate: function (menu, from, to, isOpen, ispx, unit) {
        if (this._isHorizontal) {
            if (this._isLeftPosition) {
                menu.style.left = from + (ispx ? 'px' : '%');
            }
            else {
                menu.style.right = from + (ispx ? 'px' : '%');
            }
        }
        else {
            if (this._isTopPosition) {
                menu.style.top = from + (ispx ? 'px' : '%');
            }
            else {
                menu.style.bottom = from + (ispx ? 'px' : '%');
            }
        }

        if (from != to) {
            setTimeout(function (slideMenu) {
                var value = isOpen ? from + unit : from - unit;
                slideMenu._animate(slideMenu._menu, value, to, isOpen, ispx, unit);
            }, parseInt(this.options.delay), this);
        }
        else {
            return;
        }
    },

    hide: function () {
        this._container.style.display = 'none';
    },

    show: function () {
        this._container.style.display = 'inherit';
    }
});

L.control.slideMenu = function (innerHTML, options) {
    return new L.Control.SlideMenu(innerHTML, options);
};
