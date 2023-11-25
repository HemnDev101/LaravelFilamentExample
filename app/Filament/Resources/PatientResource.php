<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {

        //used for creating new patient
        return $form
            ->schema([
                //TextField
                Forms\Components\TextInput::make('name') ->required()->maxLength(255),
                //Select Input
                Forms\Components\Select::make('type')->options([
                    'cat' => 'Cat' ,
                    'dog' => 'Dog' ,
                    'rabbit' => 'Rabbit'
                ])->required() ,
                //DatePicker
                Forms\Components\DatePicker::make('date_of_birth')->required()->maxDate(now()) ,
                //getting data from owner_id and showing name //create owner user in same page
                Forms\Components\Select::make('owner_id')->relationship('owner' , 'name')->
                required()->searchable()->preload()->createOptionForm([
                    Forms\Components\TextInput::make('name')->required()->maxLength(255) ,
                    Forms\Components\TextInput::make('email')->required()->maxLength(255)->label('Email Address')->email() ,
                    Forms\Components\TextInput::make('phone')->required()->maxLength(255)->label('Phone Number')->tel(),
                ])->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                /*used for showing all data of patients */
                Tables\Columns\TextColumn::make('name')->searchable() ,
                Tables\Columns\TextColumn::make('type') ,
                Tables\Columns\TextColumn::make('date_of_birth')->sortable() ,
                //in our table to display a list of owner names instead of less informational ID numbers.
                Tables\Columns\TextColumn::make('owner.name')->searchable() ,

            ])
            //Filtering the table by patient type
            ->filters([
               Tables\Filters\SelectFilter::make('type')->options([
                   'cat' => 'Cat'  ,
                   'dog' => 'Dog' ,
                   'rabbit' => 'Rabbit'
               ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TreatmentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
