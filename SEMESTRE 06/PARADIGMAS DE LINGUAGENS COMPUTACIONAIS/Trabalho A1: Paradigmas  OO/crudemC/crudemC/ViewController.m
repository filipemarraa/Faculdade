//
//  ViewController.m
//  crudemC
//
//  Created by Filipe Jacobson Marra on 28/08/24.
//

#import "ViewController.h"

@interface ViewController ()

@end

@implementation ViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    
    self.contacts = [[NSMutableArray alloc] init];
    
    // Configurar a UITableView
    self.tableView = [[UITableView alloc] initWithFrame:self.view.bounds style:UITableViewStylePlain];
    self.tableView.dataSource = self;
    self.tableView.delegate = self;
    [self.tableView registerClass:[UITableViewCell class] forCellReuseIdentifier:@"cell"];
    [self.view addSubview:self.tableView];
    
    // Configurar o botão de adicionar
    self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc] initWithBarButtonSystemItem:UIBarButtonSystemItemAdd target:self action:@selector(addContact)];
}

- (void)addContact {
    UIAlertController *alert = [UIAlertController alertControllerWithTitle:@"Novo Contato"
                                                                   message:@"Adicione um novo contato"
                                                            preferredStyle:UIAlertControllerStyleAlert];
    
    [alert addTextFieldWithConfigurationHandler:^(UITextField *textField) {
        textField.placeholder = @"Nome";
    }];
    
    [alert addTextFieldWithConfigurationHandler:^(UITextField *textField) {
        textField.placeholder = @"Número de Telefone";
        textField.keyboardType = UIKeyboardTypePhonePad;
    }];
    
    UIAlertAction *save = [UIAlertAction actionWithTitle:@"Salvar"
                                                   style:UIAlertActionStyleDefault
                                                 handler:^(UIAlertAction * action) {
        NSString *name = alert.textFields[0].text;
        NSString *phoneNumber = alert.textFields[1].text;
        
        NSDictionary *newContact = @{@"name": name, @"phoneNumber": phoneNumber};
        [self.contacts addObject:newContact];
        [self.tableView reloadData];
    }];
    
    UIAlertAction *cancel = [UIAlertAction actionWithTitle:@"Cancelar"
                                                     style:UIAlertActionStyleCancel
                                                   handler:nil];
    
    [alert addAction:save];
    [alert addAction:cancel];
    
    [self presentViewController:alert animated:YES completion:nil];
}

// Métodos da UITableView
- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
    return [self.contacts count];
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath {
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"cell" forIndexPath:indexPath];
    NSDictionary *contact = [self.contacts objectAtIndex:indexPath.row];
    cell.textLabel.text = contact[@"name"];
    cell.detailTextLabel.text = contact[@"phoneNumber"];
    return cell;
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath {
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
    [self editContactAtIndex:indexPath.row];
}

- (void)editContactAtIndex:(NSInteger)index {
    NSDictionary *contact = self.contacts[index];
    
    UIAlertController *alert = [UIAlertController alertControllerWithTitle:@"Editar Contato"
                                                                   message:@"Modifique as informações do contato"
                                                            preferredStyle:UIAlertControllerStyleAlert];
    
    [alert addTextFieldWithConfigurationHandler:^(UITextField *textField) {
        textField.text = contact[@"name"];
    }];
    
    [alert addTextFieldWithConfigurationHandler:^(UITextField *textField) {
        textField.text = contact[@"phoneNumber"];
        textField.keyboardType = UIKeyboardTypePhonePad;
    }];
    
    UIAlertAction *save = [UIAlertAction actionWithTitle:@"Salvar"
                                                   style:UIAlertActionStyleDefault
                                                 handler:^(UIAlertAction * action) {
        NSString *name = alert.textFields[0].text;
        NSString *phoneNumber = alert.textFields[1].text;
        
        NSDictionary *updatedContact = @{@"name": name, @"phoneNumber": phoneNumber};
        [self.contacts replaceObjectAtIndex:index withObject:updatedContact];
        [self.tableView reloadData];
    }];
    
    UIAlertAction *delete = [UIAlertAction actionWithTitle:@"Deletar"
                                                     style:UIAlertActionStyleDestructive
                                                   handler:^(UIAlertAction * _Nonnull action) {
        [self.contacts removeObjectAtIndex:index];
        [self.tableView reloadData];
    }];
    
    UIAlertAction *cancel = [UIAlertAction actionWithTitle:@"Cancelar"
                                                     style:UIAlertActionStyleCancel
                                                   handler:nil];
    
    [alert addAction:save];
    [alert addAction:delete];
    [alert addAction:cancel];
    
    [self presentViewController:alert animated:YES completion:nil];
}

@end


