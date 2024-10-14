<?php

namespace App\Filament\Resources;

use id;
use Carbon\Carbon;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\UserDetail;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form->columns([
            'md' => 1,
            '2xl' => 2,
        ])
            ->schema([
                Forms\Components\FileUpload::make('userDetails.avatar')
                    ->label('Profile picture')
                    ->avatar()
                    ->imageEditor()
                    ->circleCropper()
                    ->directory('avatars')
                    ->uploadingMessage('Uploading avatar...')
                    ->columnSpanFull()->alignCenter(),
                Forms\Components\TextInput::make('userDetails.first_name')
                    ->required()
                    ->maxLength(255)
                    ->suffix('A'),
                Forms\Components\TextInput::make('userDetails.last_name')
                    ->required()
                    ->maxLength(255)
                    ->suffix('Z'),
                Forms\Components\TextInput::make('userDetails.phone_number')
                    ->label('Phone number')
                    ->prefix('+62')
                    ->suffixIcon('heroicon-o-phone')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->suffixIcon('heroicon-o-envelope')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('userDetails.date_of_birth')
                    ->native(false)
                    ->displayFormat('d F Y')
                    ->suffixIcon('heroicon-o-calendar'),
                Forms\Components\Select::make('userDetails.gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ])->suffixIcon('heroicon-o-user'),
                Forms\Components\Textarea::make('userDetails.address')
                    ->minLength(2)
                    ->maxLength(300)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->revealable()
                    ->visibleOn(['create'])
                    ->maxLength(255),
                Forms\Components\TextInput::make('password_confirmation')
                    ->password()
                    ->required()
                    ->visibleOn(['create'])
                    ->same('password')
                    ->label('Confirm Password')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('userDetails.phone_number')
                    ->label('Phone number')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->default(0)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('id','!=', auth()->id());
            })
            ->filters([
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email verification')
                    ->nullable()
                    ->placeholder('All users')
                    ->trueLabel('Verified')
                    ->falseLabel('Not verified'),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('Created from'),
                        Forms\Components\DatePicker::make('created_until')->label('Created until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Created from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Created until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->filtersApplyAction(
                fn(Action $action) => $action
                    ->link()
                    ->label('Save filters to table'),
            )
            ->filtersTriggerAction(
                fn(Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->actions([
                Tables\Actions\ViewAction::make()->mutateRecordDataUsing(function (array $data, User $record): array {
                    $userDetails = $record->userDetails;
                    if ($userDetails) {
                        $data['userDetails'] = [
                            'first_name' => $userDetails->first_name,
                            'last_name' => $userDetails->last_name,
                            'phone_number' => $userDetails->phone_number,
                            'date_of_birth' => $userDetails->date_of_birth,
                            'avatar' => $userDetails->avatar,
                            'gender' => $userDetails->gender,
                            'address' => $userDetails->address,
                        ];
                    }

                    return $data;
                })->modalFooterActionsAlignment('end'),
                Tables\Actions\EditAction::make()->mutateRecordDataUsing(function (array $data, User $record): array {
                    $userDetails = $record->userDetails;
                    if ($userDetails) {
                        $data['userDetails'] = [
                            'first_name' => $userDetails->first_name,
                            'last_name' => $userDetails->last_name,
                            'phone_number' => $userDetails->phone_number,
                            'date_of_birth' => $userDetails->date_of_birth,
                            'avatar' => $userDetails->avatar,
                            'gender' => $userDetails->gender,
                            'address' => $userDetails->address,
                        ];
                    }

                    return $data;
                })->after(function ($record, array $data): void {
                    UserDetail::where('user_id', $record->id)->update($data['userDetails']);
                    $name = $data['userDetails']['first_name'] . ' ' . $data['userDetails']['last_name'];
                    User::where('id', $record->id)->update(['name' => $name]);
                })->modalFooterActionsAlignment('end'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
