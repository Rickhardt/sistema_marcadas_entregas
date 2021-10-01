# REAMDE

Sistema de marcadas y de entrega de misceláneos.

# Hitos

Este sistema es el que se utiliza para la revisión de marcadas de entradas y salidas de todo el personal (que marca por supuesto). Además contiene el susbsistema de entregas de misceláneos, para 09-2021 se está configurado para la entrega de los badge nuevos luego del cambio de logo que entró en efecto el 01-10-2021.

- Se modificó la presentación de la página.
- Se cambió la imagen que se mostraba, dado que originalmente era para la entrega de chompipollos en diciembre se tuvo que cambiar por una que fuera apropiado al nuevo uso que iba a tener.
- Se agregaron algunas validaciones (como que mostrara la fotografía de la persona antes de modificar el estado de PENDIENTE a ENTREGADO en la base de datos).
- Se modificaron algunos controles para evitar errores (como que los campos de badge únicamente aceptaran números).
- Se agregó una pantalla para el ingreso de correlativo del carnet de transporte.
- Se modifcó la pantalla de actualización éxitosa de estado, dado que ya no era necesaria la antigua (porque mostraba una imagen navideña y reproducía un jingle navideño).

Cambios realizados el 01-10-2021

- Se modificó el código para que cuando el campo de correlativo este vacío muestre un error y no pase a la pantalla de "éxito".
