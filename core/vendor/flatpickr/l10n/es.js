(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
  typeof define === 'function' && define.amd ? define(['exports'], factory) :
  (global = global || self, factory(global.es = {}));
}(this, function (exports) { 'use strict';

  var fp = typeof window !== "undefined" && window.flatpickr !== undefined
      ? window.flatpickr
      : {
          l10ns: {}
      };
  var Spanish = {
      firstDayOfWeek: 1,
      weekdays: {
          shorthand: ["dom", "lun", "mar", "mie", "jue", "vie", "sab"],
          longhand: [
			   "Domingo",
               "Lunes",
               "Martes",
               "Miércoles",
               "Jueves",
               "Viernes",
               "Sábado",
          ]
      },
      months: {
          shorthand: [
              "ene",
              "feb",
              "mar",
              "abr",
              "may",
              "jun",
              "jul",
              "ago",
              "sept",
              "oct",
              "nov",
              "dic",
          ],
          longhand: [
			   "Enero",
               "Febrero",
               "marzo",
               "abril",
               "mayo",
               "Junio",
               "julio",
               "agosto",
               "septiembre",
               "octubre",
               "noviembre",
               "Diciembre",
          ]
      },
      ordinal: function (nth) {
          if (nth > 1)
              return "";
          return "er";
      },
      rangeSeparator: " al ",
      weekAbbreviation: "Sem",
      scrollTitle: "Desplácese para aumentar el valor",
      toggleTitle: "Haga clic para alternar",
      time_24hr: true
  };
  fp.l10ns.es = Spanish;
  var es = fp.l10ns;

  exports.Spanish = Spanish;
  exports.default = es;

  Object.defineProperty(exports, '__esModule', { value: true });

}));