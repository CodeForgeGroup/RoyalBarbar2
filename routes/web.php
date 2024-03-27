<?php

use App\Http\Controllers\BarbeiroController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CadastrarController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\CortesController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\GerenteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SobreController;
use App\Models\Cadastrar;
use Faker\Guesser\Name;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/sobre', [SobreController::class, 'index'])->name('sobre');


//CORTES
Route::get('/cortes', [CortesController::class, 'index'])->name('cortes');
Route::get('/servicos/barba', [CortesController::class, 'barba'])->name('barba');
Route::get('/servicos/coloracao', [CortesController::class, 'coloracao'])->name('coloracao');
Route::get('/servicos/cuidados', [CortesController::class, 'cuidados'])->name('cuidados');
Route::get('/servicos/tratamento', [CortesController::class, 'tratamento'])->name('tratamento');


// CONTATO
Route::get('/contato', [ContatoController::class, 'index'])->name('contato');
// Route::get('/contato/enviar', [ContatoController::class, 'salvarNoBanco'])->name('contato.enviar');
// Route::get('/contato/enviarnew', [ContatoController::class, 'salvarEmail'])->name('contato.enviarnew');

// LOGIN
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login',[LoginController::class, 'autenticar'])->name('login');

Route::get('/cadastrar', [CadastrarController::class, 'index'])->name('cadastrar');
Route::post('/cadastrar', [CadastrarController::class, 'cadastrar'])->name('cadastrar');


// AUTENTICAÇÃO DE GERENTE
Route::middleware(['autenticacao:gerente'])->group(function() {
    Route::get('/dashboard/gerente', [GerenteController::class, 'index'])->name('gerente');
});

// AUTENTICAÇÃO DE BARBEIRO (FUNCIONÁRIO COMUM)
Route::middleware(['autenticacao:barbeiro'])->group(function () {
    Route::get('/dashboard/barbeiro', [BarbeiroController::class, 'index'])->name('barbeiro');
});

// AUTENTICAÇÃO DE CLIENTE
Route::middleware(['autenticacao:cliente'])->group(function () {
    Route::get('/dashboard/cliente', [ClienteController::class, 'index'])->name('cliente');
});

Route::get('/sair', function() {
    session()->flush();
    return redirect('/');
})->name('sair');
