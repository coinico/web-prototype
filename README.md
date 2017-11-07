
# Prototipo WEB de la Plataforma CasaToken

### Installation ###

* type `composer install`
* type `composer update`
* copy *.env.example* to *.env*
* type `php artisan key:generate`to generate secure key in *.env* file
* if you use MySQL in *.env* file :
   * set DB_CONNECTION
   * set DB_DATABASE
   * set DB_USERNAME
   * set DB_PASSWORD
* type `php artisan migrate --seed` to create and populate tables
* edit *.env* for emails configuration

# Plataforma descentralizada para el 
# Futuro de las propiedades inmobiliarias

Para entender el proyecto podramos pensar en el problema que se le presenta a una persona que desea comprar una propiedad inmobiliaria cuando carece de capital. En la la mayoría de los países del mundo, el mecanismo más común es a través de un sistema de créditos bancarios. Este mecanismo no es de simple acceso para las personas de menores recursos, lleva a que las personas mantengan una una deuda por una gran cantidad de años y presenta riesgos financieros para todos los actores intervinientes. Notemos que la carencia de recursos perjudica también a propietarios de inmuebles que desean obtener liquidez monetaria y no consiguen comprador.

Nuestra idea (de manera simplificada) es pensar en una propiedad de la misma forma en que podemos pensar en una empresa cotizada en una bolsa de valores. Los accionistas pueden obtener porciones de la empresa (acciones) que le dan un derecho a obtener dividendos sobre las ganancias de la empresa. Los dueños mayoritarios pueden obtener liquidez al vender porciones de la empresa mientras mantienen el control de la misma; y a su vez se presenta la posibilidad de que los propietarios iniciales se desprendan de la mayor parte de la empresa y al mismo tiempo sigan siendo beneficiados por dividendos u opinión en tomas de decisiones.

Si tomamos un inmueble y codificamos su derecho de propiedad en un número de "acciones" (que llamaremos tokens), el dueño de la propiedad puede llamar a una oferta pública inicial sobre su inmueble proponiendo un valor esperado sobre cada token. Si hay suficiente dinero ofertado para obtener estos tokens, estos se distribuirán luego entre quienes ofertaron dinero por los mismos, obteniendo así una proporción del derecho de propiedad sobre el inmueble.

En este sistema, pequeños inversores podrán invertir sus ahorros en partes de un inmueble mientras acumulan capital; el dueño original del inmueble obtiene liquidez; el mercado de oferta pública puede inducir a que agentes de compra se contacten para negocios que no harían por separado; inmuebles de bajo atractivo podrían atraer atención al ser fraccionados en tokens (evitando que sea un único inversor quien deba afrontar los riesgos); y a su vez nace la posibilidad de nuevas modalidades de negocios inmobiliarios (por ejemplo, ser el propietario mayoritario de una propiedad y utilizarla mientra se paga un alquiler al resto de los propietarios).

A su vez planteamos la creación de un equivalente a una bolsa inmobiliaria donde los tokens creadas por cada propiedad tomen el rol de acciones en una empresa.

La tecnología blcokchain y, en particular, la de smart contracts será el núcleo tecnológico para administrar los títulos de propiedad y pagos sobre este mercado.
