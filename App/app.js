var app = angular.module('myApp', ['ngRoute']);
app.factory("services", ['$http', function($http) {
  var serviceBase = '/'
    var obj = {};
	
	//Products
	   obj.getInvoiceProducts = function(){
        return $http.get(serviceBase + 'products/invoices');
    }
    obj.getProducts = function(){
        return $http.get(serviceBase + 'products');
    }
    obj.getProduct = function(productNumber){
        return $http.get(serviceBase + 'products/' + productNumber);
    }

    obj.insertProduct = function (product) {
        return $http.post(serviceBase + 'products', product).then(function (results) {
        return results;
    });
	};

	obj.updateProduct = function (id,product) {
	    return $http.post(serviceBase + 'products', {id:id, product:product}).then(function (status) {
	        return status.data;
	    });
	};

	obj.deleteProduct = function (id) {
	    return $http.delete(serviceBase + 'products/' + id).then(function (status) {
	        return status.data;
	    });
	};
	
	//Categories
	    obj.getCategories = function(){
        return $http.get(serviceBase + 'categories');
    }
    obj.getCategory = function(categoryNumber){
        return $http.get(serviceBase + 'categories/' + categoryNumber);
    }

    obj.insertCategory = function (category) {
    return $http.post(serviceBase + 'categories', category).then(function (results) {
        return results;
    });
	};

	obj.updateCategory = function (id,category) {
	    return $http.post(serviceBase + 'categories', {id:id, category:category}).then(function (status) {
	        return status.data;
	    });
	};

	obj.deleteCategory = function (id) {
	    return $http.delete(serviceBase + 'categories/' + id).then(function (status) {
	        return status.data;
	    });
	};
	
	//Taxes
	obj.getTaxes = function(){
        return $http.get(serviceBase + 'taxes');
    }
	obj.getTax = function(taxNumber){
        return $http.get(serviceBase + 'taxes/' + taxNumber);
    }

    obj.insertTax = function (tax) {
    return $http.post(serviceBase + 'taxes', tax).then(function (results) {
        return results;
    });
	};

	obj.updateTax = function (id,tax) {
	    return $http.post(serviceBase + 'taxes', {id:id, tax:tax}).then(function (status) {
	        return status.data;
	    });
	};

	obj.deleteTax = function (id) {
	    return $http.delete(serviceBase + 'taxes/' + id).then(function (status) {
	        return status.data;
	    });
	};

    return obj;   
}]);

app.controller('listProductsCtrl', function ($scope, services) {
    services.getProducts().then(function(data) {
        $scope.products = data.data;
    });
});

app.controller('editProductCtrl', function ($scope, $rootScope, $location, $routeParams, services, product, categories) {
    var productNumber = ($routeParams.productNumber) ? parseInt($routeParams.productNumber) : 0;
    $rootScope.title = 'Editar Produto';
    $scope.buttonText = 'Update Produto';
    var original = product.data[0];
    original._id = productNumber;
    
    $scope.product = angular.copy(original);
    $scope.product._id = productNumber;
    
    $scope.filterCondition= {
        productCategoryNumber: product.data[0].productCategoryNumber
    }
    
    $scope.categories = categories.data;

    $scope.deleteProduct = function(product) {
      $location.path('/products');
      if(confirm("Tem certeza que deseja excluir o produto: "+$scope.product._id)==true)
      services.deleteProduct(product.productNumber);
    };

    $scope.saveProduct = function(product) {
      $location.path('/products');
      services.updateProduct(productNumber, product);
    };
});

app.controller('newProductCtrl', function ($scope, $rootScope, $location, $routeParams, services, categories) {
    $rootScope.title = 'Adicionar Produto';
    $scope.buttonText = 'Adicionar Novo Produto';
    
    $scope.categories = categories.data;
    
    var product = {}
        
    $scope.product = {
        productName: "",
        productDescription:  "",
        productPrice: "",
        productCategoryNumber: ""
      }
    
    $scope.saveProduct = function(product) {
      $location.path('/products');
      services.insertProduct(product);
    };
});

app.controller('listCategoriesCtrl', function ($scope, services) {
    services.getCategories().then(function(data) {
        $scope.categories = data.data;
    });
});

app.controller('editCategoryCtrl', function ($scope, $rootScope, $location, $routeParams, services, category, taxes) {
    var categoryNumber = ($routeParams.categoryNumber) ? parseInt($routeParams.categoryNumber) : 0;
    $rootScope.title = 'Editar Categoria';
    $scope.buttonText = 'Update Categoria';
    var original = category.data[0];
    original._id = categoryNumber;
    
    $scope.category = angular.copy(original);
    $scope.category._id = categoryNumber;
    
    $scope.filterCondition= {
        categoryTaxNumber: category.data[0].categoryTaxNumber
    }
    
    $scope.taxes = taxes.data;

    $scope.deleteCategory = function(category) {
      $location.path('/categories');
      if(confirm("Tem certeza que deseja excluir a categoria: "+$scope.category._id)==true)
      services.deleteCategory(category.categoryNumber);
    };

    $scope.saveCategory = function(category) {
      $location.path('/categories');
      services.updateCategory(categoryNumber, category);
    };
});

app.controller('newCategoryCtrl', function ($scope, $rootScope, $location, $routeParams, services, taxes) {
    $rootScope.title = 'Adicionar Categoria';
    $scope.buttonText = 'Adicionar Nova Categoria';
    
    $scope.taxes = taxes.data;
    
    var category = {}
        
    $scope.category = {
        categoryName: "",
        categoryDescription:  "",
        categoryTaxNumber: ""
      }
    
    $scope.saveCategory = function(category) {
      $location.path('/categories');
      services.insertCategory(category);
    };
});

app.controller('listTaxesCtrl', function ($scope, services) {
    services.getTaxes().then(function(data) {
        $scope.taxes = data.data;
    });
});

app.controller('editTaxCtrl', function ($scope, $rootScope, $location, $routeParams, services, tax) {
    var taxNumber = ($routeParams.taxNumber) ? parseInt($routeParams.taxNumber) : 0;
    $rootScope.title = 'Editar Imposto';
    $scope.buttonText = 'Update Imposto';
    var original = tax.data[0];
    original._id = taxNumber;
    
    $scope.tax = angular.copy(original);
    $scope.tax._id = taxNumber;

    $scope.deleteTax = function(tax) {
      $location.path('/taxes');
      if(confirm("Tem certeza que deseja excluir o imposto: "+$scope.tax._id)==true)
      services.deleteTax(tax.taxNumber);
    };

    $scope.saveTax = function(tax) {
      $location.path('/taxes');
      services.updateTax(taxNumber, tax);
    };
});

app.controller('newTaxCtrl', function ($scope, $rootScope, $location, $routeParams, services) {
    $rootScope.title = 'Adicionar Imposto';
    $scope.buttonText = 'Adicionar Novo Imposto';
    
    var tax = {}
        
    $scope.tax = {
        taxName: "",
        taxDescription:  "",
        taxPercentage: ""
      }
    
    $scope.saveTax = function(tax) {
      $location.path('/taxes');
      services.insertTax(tax);
    };
});

app.controller('invoicesCtrl', function ($scope, $rootScope, $location, $routeParams, services, products) {
    
    $rootScope.title = 'Selecione o produto:';
    $scope.buttonText = 'Adicionar Novo Produto';
    
    $scope.products = products.data;
    
    $scope.todoList = [{}];
  
    $scope.todoAdd = function() {
        $scope.todoList.push({
          product:$scope.product.split(',')[0], 
          price:parseFloat($scope.product.split(',')[1]), 
          amount:$scope.amount, 
          tax: parseFloat($scope.product.split(',')[2]) / 100 * parseFloat($scope.product.split(',')[1]) * $scope.amount,
          value: parseFloat($scope.product.split(',')[1]) * $scope.amount, 
          valueWithTax: (((parseFloat($scope.product.split(',')[2]) / 100) * parseFloat($scope.product.split(',')[1]) * $scope.amount) + (parseFloat($scope.product.split(',')[1]) * $scope.amount)),
      done:false});
      $scope.getTotal()
    };
    
    $scope.totals = {
       totalQuantidade: 0,
       totalProdutos: 0,
       totalImpostos: 0,
       totalComImpostos: 0
    }
    
    $scope.getTotal = function () {
      for(var i = $scope.todoList.length-1; i < $scope.todoList.length; i++) {
            var list = $scope.todoList[i];
            $scope.totals.totalQuantidade += parseFloat(list.amount);
            $scope.totals.totalProdutos += parseFloat(list.value);
            $scope.totals.totalImpostos += parseFloat(list.tax);
            $scope.totals.totalComImpostos += parseFloat(list.valueWithTax);
        }
    }
    
    $scope.getTotalRemovido = function () {
      
      $scope.totals.totalQuantidade = 0;
      $scope.totals.totalProdutos = 0;
      $scope.totals.totalImpostos = 0;
      $scope.totals.totalComImpostos =0;
      
      for(var i = 1; i < $scope.todoList.length; i++) {
            var list = $scope.todoList[i];
            $scope.totals.totalQuantidade += parseFloat(list.amount);
            $scope.totals.totalProdutos += parseFloat(list.value);
            $scope.totals.totalImpostos += parseFloat(list.tax);
            $scope.totals.totalComImpostos += parseFloat(list.valueWithTax);
        }
    }
    
    $scope.remove = function() {
        var oldList = $scope.todoList;
        $scope.todoList = [];
        angular.forEach(oldList, function(x) {
            if (!x.done) $scope.todoList.push(x);
        });
        $scope.getTotalRemovido()
    };

  
});

app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/products', {
        title: 'Produtos',
        templateUrl: 'App/Partials/Product/products.html',
        controller: 'listProductsCtrl'
      })
      .when('/product/edit/:productNumber', {
        title: 'Editar Produto',
        templateUrl: 'App/Partials/Product/edit.html',
        controller: 'editProductCtrl',
        resolve: {
          product: function(services, $route){
            var productNumber = $route.current.params.productNumber;
            return services.getProduct(productNumber);
          },
          categories: function(services, $route){
            return services.getCategories();
          }
        }
      })
      .when('/product/new', {
        title: 'Adicionar Produto',
        templateUrl: 'App/Partials/Product/new.html',
        controller: 'newProductCtrl',
        resolve: {
          categories: function(services, $route){
            return services.getCategories();
          }
        }
      })
      .when('/categories', {
        title: 'Categorias',
        templateUrl: 'App/Partials/Category/categories.html',
        controller: 'listCategoriesCtrl'
      })
      .when('/category/edit/:categoryNumber', {
        title: 'Editar Categoria',
        templateUrl: 'App/Partials/Category/edit.html',
        controller: 'editCategoryCtrl',
        resolve: {
          category: function(services, $route){
            var categoryNumber = $route.current.params.categoryNumber;
            return services.getCategory(categoryNumber);
          },
          taxes: function(services, $route){
            return services.getTaxes();
          }
        }
      })
      .when('/category/new', {
        title: 'Adicionar Categoria',
        templateUrl: 'App/Partials/Category/new.html',
        controller: 'newCategoryCtrl',
        resolve: {
          taxes: function(services, $route){
            return services.getTaxes();
          }
        }
      })
      .when('/taxes', {
        title: 'Impostos',
        templateUrl: 'App/Partials/Tax/taxes.html',
        controller: 'listTaxesCtrl'
      })
      .when('/tax/edit/:taxNumber', {
        title: 'Editar Imposto',
        templateUrl: 'App/Partials/Tax/edit.html',
        controller: 'editTaxCtrl',
        resolve: {
          tax: function(services, $route){
            var taxNumber = $route.current.params.taxNumber;
            return services.getTax(taxNumber);
          }
        }
      })
      .when('/tax/new', {
        title: 'Adicionar Imposto',
        templateUrl: 'App/Partials/Tax/new.html',
        controller: 'newTaxCtrl',
      })
      .when('/invoices', {
        title: 'Cadastrar Venda',
        templateUrl: 'App/Partials/Invoice/invoices.html',
        controller: 'invoicesCtrl',
        resolve: {
          products: function(services, $route){
            return services.getInvoiceProducts();
          }
        }
      })
      .otherwise({
        redirectTo: '/invoices'
      });
}]);